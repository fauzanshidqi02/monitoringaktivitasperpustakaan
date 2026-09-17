<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Module;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private function normalizeRole(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        return strtolower(str_replace([' ', '-'], '_', trim($value)));
    }

    private function userRoleSlug(): ?string
    {
        $user = auth()->user();

        if (!$user) {
            return null;
        }

        $role = $user->role ?? null;

        if (is_object($role)) {
            return $this->normalizeRole($role->slug ?? $role->name ?? null);
        }

        return $this->normalizeRole((string) $role);
    }

    private function isManagerRole(): bool
    {
        return in_array($this->userRoleSlug(), [
            'super_admin',
            'admin',
            'kepala_perpustakaan',
            'koordinator',
        ], true);
    }

    private function baseActivityQuery(): Builder
    {
        $query = Activity::query();

        if (!$this->isManagerRole()) {
            $query->where(function ($q) {
                $q->where('created_by', auth()->id())
                    ->orWhere('assigned_to', auth()->id());
            });
        }

        return $query;
    }

    public function index(): View
    {
        $selectedYear = request('year') ? (int) request('year') : (int) now()->format('Y');

        $years = $this->baseActivityQuery()
            ->selectRaw('YEAR(activity_date) as year')
            ->whereNotNull('activity_date')
            ->distinct()
            ->orderByRaw('YEAR(activity_date) DESC')
            ->pluck('year')
            ->filter()
            ->values();

        if (!$years->contains($selectedYear)) {
            $years->push($selectedYear);
        }

        if (!$years->contains((int) now()->format('Y'))) {
            $years->push((int) now()->format('Y'));
        }

        $years = $years->unique()->sortDesc()->values();

        $yearBaseQuery = $this->baseActivityQuery()
            ->whereYear('activity_date', $selectedYear);

        $summary = [
            'total' => (clone $yearBaseQuery)->count(),
            'draft' => (clone $yearBaseQuery)->where('status', 'draft')->count(),
            'submitted' => (clone $yearBaseQuery)->where('status', 'submitted')->count(),
            'on_review' => (clone $yearBaseQuery)->where('status', 'on_review')->count(),
            'revision' => (clone $yearBaseQuery)->where('status', 'revision')->count(),
            'approved' => (clone $yearBaseQuery)->where('status', 'approved')->count(),
            'completed' => (clone $yearBaseQuery)->where('status', 'completed')->count(),
            'rejected' => (clone $yearBaseQuery)->where('status', 'rejected')->count(),
        ];

        $chartLabels = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des',
        ];

        $chartModules = Module::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $monthlyRows = $this->baseActivityQuery()
            ->selectRaw('module_id, MONTH(activity_date) as activity_month, COUNT(*) as total')
            ->whereYear('activity_date', $selectedYear)
            ->whereNotNull('activity_date')
            ->whereIn('module_id', $chartModules->pluck('id'))
            ->groupBy('module_id')
            ->groupByRaw('MONTH(activity_date)')
            ->get();

        $colors = [
            '#0d6efd',
            '#adb5bd',
            '#28a745',
            '#ffc107',
            '#6610f2',
            '#fd7e14',
            '#20c997',
            '#dc3545',
            '#0dcaf0',
            '#6f42c1',
        ];

        $chartDatasets = [];

        foreach ($chartModules as $index => $module) {
            $data = [];

            for ($month = 1; $month <= 12; $month++) {
                $row = $monthlyRows
                    ->where('module_id', $module->id)
                    ->where('activity_month', $month)
                    ->first();

                $data[] = $row ? (int) $row->total : 0;
            }

            $color = $colors[$index % count($colors)];

            $chartDatasets[] = [
                'label' => $module->name,
                'data' => $data,
                'backgroundColor' => $color,
                'borderColor' => $color,
                'borderWidth' => 1,
            ];
        }

        $moduleTotals = $this->baseActivityQuery()
            ->selectRaw('module_id, COUNT(*) as total')
            ->whereYear('activity_date', $selectedYear)
            ->whereIn('module_id', $chartModules->pluck('id'))
            ->groupBy('module_id')
            ->pluck('total', 'module_id');

        return view('dashboard.index', compact(
            'selectedYear',
            'years',
            'summary',
            'chartLabels',
            'chartDatasets',
            'chartModules',
            'moduleTotals'
        ));
    }
}
