<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Module;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
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

    private function baseActivityQuery(Request $request)
    {
        $query = Activity::with([
            'module',
            'category',
            'creator',
            'assignedUser',
            'approver',
        ])
            ->latest('activity_date')
            ->latest();

        if (!$this->isManagerRole()) {
            $query->where(function ($q) {
                $q->where('created_by', auth()->id())
                    ->orWhere('assigned_to', auth()->id());
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('activity_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('activity_date', '<=', $request->date_to);
        }

        if ($request->filled('module_id')) {
            $query->where('module_id', $request->module_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    private function makeSummary($baseQuery): array
    {
        return [
            'total' => (clone $baseQuery)->count(),
            'draft' => (clone $baseQuery)->where('status', 'draft')->count(),
            'submitted' => (clone $baseQuery)->where('status', 'submitted')->count(),
            'on_review' => (clone $baseQuery)->where('status', 'on_review')->count(),
            'revision' => (clone $baseQuery)->where('status', 'revision')->count(),
            'approved' => (clone $baseQuery)->where('status', 'approved')->count(),
            'completed' => (clone $baseQuery)->where('status', 'completed')->count(),
            'rejected' => (clone $baseQuery)->where('status', 'rejected')->count(),
        ];
    }

    private function makeFilters(Request $request): array
    {
        $moduleName = 'Semua Modul';

        if ($request->filled('module_id')) {
            $module = Module::find($request->module_id);
            $moduleName = $module?->name ?? 'Modul tidak ditemukan';
        }

        return [
            'date_from' => $request->date_from ?: '-',
            'date_to' => $request->date_to ?: '-',
            'module' => $moduleName,
            'status' => $request->status
                ? ucwords(str_replace('_', ' ', $request->status))
                : 'Semua Status',
            'search' => $request->search ?: '-',
        ];
    }

    public function activities(Request $request)
    {
        $baseQuery = $this->baseActivityQuery($request);

        $summary = $this->makeSummary($baseQuery);

        $activities = $baseQuery->paginate(10)->withQueryString();

        $modules = Module::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('reports.activities', compact(
            'activities',
            'modules',
            'summary'
        ));
    }

    public function exportActivities(Request $request)
    {
        $activities = $this->baseActivityQuery($request)->get();

        $fileName = 'laporan-aktivitas-' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        return response()->stream(function () use ($activities) {
            $handle = fopen('php://output', 'w');

            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'Tanggal Aktivitas',
                'Judul Aktivitas',
                'Deskripsi',
                'Modul',
                'Jenis Aktivitas',
                'PIC',
                'Dibuat Oleh',
                'Jumlah',
                'Satuan',
                'Status',
                'Disetujui Oleh',
                'Tanggal Approval',
                'Tanggal Selesai',
                'Catatan',
            ], ';');

            foreach ($activities as $activity) {
                fputcsv($handle, [
                    $activity->activity_date ? $activity->activity_date->format('d-m-Y') : '-',
                    $activity->title ?? '-',
                    $activity->description ?? '-',
                    $activity->module->name ?? '-',
                    $activity->category->name ?? '-',
                    $activity->assignedUser->name ?? '-',
                    $activity->creator->name ?? '-',
                    $activity->quantity ?? '-',
                    $activity->unit ?? '-',
                    ucwords(str_replace('_', ' ', $activity->status)),
                    $activity->approver->name ?? '-',
                    $activity->approved_at ? $activity->approved_at->format('d-m-Y H:i') : '-',
                    $activity->completed_at ? $activity->completed_at->format('d-m-Y H:i') : '-',
                    $activity->notes ?? '-',
                ], ';');
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function exportActivitiesPdf(Request $request)
    {
        $baseQuery = $this->baseActivityQuery($request);

        $summary = $this->makeSummary($baseQuery);
        $activities = $baseQuery->get();
        $filters = $this->makeFilters($request);

        $fileName = 'laporan-aktivitas-' . now()->format('Ymd_His') . '.pdf';

        $pdf = Pdf::loadView('reports.activities-pdf', compact(
            'activities',
            'summary',
            'filters'
        ))->setPaper('a4', 'landscape');

        return $pdf->download($fileName);
    }
}
