<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\ActivityStatusLog;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ActivityController extends Controller
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

    private function authorizeActivityAccess(Activity $activity): void
    {
        if ($this->isManagerRole()) {
            return;
        }

        $userId = auth()->id();

        if ((int) $activity->created_by !== (int) $userId && (int) $activity->assigned_to !== (int) $userId) {
            abort(403, 'Anda tidak memiliki akses ke aktivitas ini.');
        }
    }

    private function authorizeActivityEdit(Activity $activity): void
    {
        $this->authorizeActivityAccess($activity);

        if ($this->isManagerRole()) {
            return;
        }

        if (!in_array($activity->status, ['draft', 'revision'], true)) {
            abort(403, 'Aktivitas yang sudah diajukan/review tidak dapat diedit oleh staf.');
        }
    }

    private function allowedUpdateStatuses(): array
    {
        if ($this->isManagerRole()) {
            return [
                'draft',
                'submitted',
                'on_review',
                'revision',
                'approved',
                'completed',
                'rejected',
            ];
        }

        return [
            'draft',
            'submitted',
        ];
    }

    private function approvalDataForStatus(string $status, Activity $activity): array
    {
        if ($status === 'approved') {
            return [
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'completed_at' => null,
            ];
        }

        if ($status === 'completed') {
            return [
                'approved_by' => $activity->approved_by ?: auth()->id(),
                'approved_at' => $activity->approved_at ?: now(),
                'completed_at' => now(),
            ];
        }

        if (in_array($status, ['draft', 'submitted', 'on_review', 'revision', 'rejected'], true)) {
            return [
                'approved_by' => null,
                'approved_at' => null,
                'completed_at' => null,
            ];
        }

        return [];
    }

    public function index(Request $request)
    {
        $query = Activity::with(['module', 'category', 'creator', 'assignedUser'])
            ->latest('activity_date')
            ->latest();

        if (!$this->isManagerRole()) {
            $query->where(function ($q) {
                $q->where('created_by', auth()->id())
                    ->orWhere('assigned_to', auth()->id());
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        if ($request->filled('module_id')) {
            $query->where('module_id', $request->module_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('activity_date')) {
            $query->whereDate('activity_date', $request->activity_date);
        }

        $activities = $query->paginate(10)->withQueryString();

        $modules = Module::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('activities.index', compact('activities', 'modules'));
    }

    public function create()
    {
        $modules = Module::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $categories = ActivityCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        if ($this->isManagerRole()) {
            $users = User::with('role')
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        } else {
            $users = User::with('role')
                ->where('id', auth()->id())
                ->get();
        }

        return view('activities.create', compact('modules', 'categories', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_id' => ['required', 'exists:modules,id'],
            'activity_category_id' => ['nullable', 'exists:activity_categories,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'activity_date' => ['required', 'date'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'unit' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:draft,submitted'],
            'evidence_required' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string'],
        ]);

        $assignedTo = $this->isManagerRole()
            ? ($validated['assigned_to'] ?? null)
            : auth()->id();

        $activity = Activity::create([
            'module_id' => $validated['module_id'],
            'activity_category_id' => $validated['activity_category_id'] ?? null,
            'created_by' => auth()->id(),
            'assigned_to' => $assignedTo,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'activity_date' => $validated['activity_date'],
            'quantity' => $validated['quantity'] ?? null,
            'unit' => $validated['unit'] ?? null,
            'status' => $validated['status'],
            'input_source' => 'manual',
            'evidence_required' => $request->boolean('evidence_required'),
            'notes' => $validated['notes'] ?? null,
        ]);

        ActivityStatusLog::create([
            'activity_id' => $activity->id,
            'changed_by' => auth()->id(),
            'old_status' => null,
            'new_status' => $activity->status,
            'note' => 'Aktivitas dibuat melalui input manual.',
        ]);

        return redirect()
            ->route('activities.index')
            ->with('success', 'Aktivitas berhasil ditambahkan.');
    }

    public function show(Activity $activity)
    {
        $this->authorizeActivityAccess($activity);

        $activity->load([
            'module',
            'category',
            'creator',
            'assignedUser',
            'approver',
            'statusLogs.changedBy',
            'comments.user',
            'files.uploader',
        ]);

        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity)
    {
        $this->authorizeActivityEdit($activity);

        $modules = Module::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $categories = ActivityCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        if ($this->isManagerRole()) {
            $users = User::with('role')
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        } else {
            $users = User::with('role')
                ->where('id', auth()->id())
                ->get();
        }

        $statusOptions = $this->allowedUpdateStatuses();

        return view('activities.edit', compact('activity', 'modules', 'categories', 'users', 'statusOptions'));
    }

    public function update(Request $request, Activity $activity)
    {
        $this->authorizeActivityEdit($activity);

        $statusOptions = $this->allowedUpdateStatuses();

        $validated = $request->validate([
            'module_id' => ['required', 'exists:modules,id'],
            'activity_category_id' => ['nullable', 'exists:activity_categories,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'activity_date' => ['required', 'date'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'unit' => ['nullable', 'string', 'max:100'],
            'status' => ['required', Rule::in($statusOptions)],
            'evidence_required' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string'],
        ]);

        $oldStatus = $activity->status;
        $newStatus = $validated['status'];

        $assignedTo = $this->isManagerRole()
            ? ($validated['assigned_to'] ?? null)
            : $activity->assigned_to;

        $updateData = [
            'module_id' => $validated['module_id'],
            'activity_category_id' => $validated['activity_category_id'] ?? null,
            'assigned_to' => $assignedTo,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'activity_date' => $validated['activity_date'],
            'quantity' => $validated['quantity'] ?? null,
            'unit' => $validated['unit'] ?? null,
            'status' => $newStatus,
            'evidence_required' => $request->boolean('evidence_required'),
            'notes' => $validated['notes'] ?? null,
        ];

        if ($oldStatus !== $newStatus) {
            $updateData = array_merge(
                $updateData,
                $this->approvalDataForStatus($newStatus, $activity)
            );
        }

        $activity->update($updateData);

        if ($oldStatus !== $activity->status) {
            ActivityStatusLog::create([
                'activity_id' => $activity->id,
                'changed_by' => auth()->id(),
                'old_status' => $oldStatus,
                'new_status' => $activity->status,
                'note' => 'Status aktivitas diperbarui.',
            ]);
        }

        return redirect()
            ->route('activities.index')
            ->with('success', 'Aktivitas berhasil diperbarui.');
    }

    public function destroy(Activity $activity)
    {
        $this->authorizeActivityEdit($activity);

        $activity->delete();

        return redirect()
            ->route('activities.index')
            ->with('success', 'Aktivitas berhasil dihapus.');
    }
}
