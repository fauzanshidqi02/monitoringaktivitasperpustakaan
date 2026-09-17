<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityComment;
use App\Models\ActivityStatusLog;
use Illuminate\Http\Request;

class ActivityReviewController extends Controller
{
    private function authorizeReviewer(): void
    {
        $allowedRoles = [
            'super_admin',
            'admin',
            'kepala_perpustakaan',
            'koordinator',
        ];

        if (!in_array(auth()->user()->role?->slug, $allowedRoles)) {
            abort(403, 'Anda tidak memiliki akses untuk review aktivitas.');
        }
    }

    public function edit(Activity $activity)
    {
        $this->authorizeReviewer();

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

        return view('activities.review', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $this->authorizeReviewer();

        $validated = $request->validate([
            'status' => [
                'required',
                'in:on_review,revision,approved,completed,rejected',
            ],
            'note' => [
                'nullable',
                'string',
            ],
        ]);

        $oldStatus = $activity->status;
        $newStatus = $validated['status'];

        $updateData = [
            'status' => $newStatus,
        ];

        if ($newStatus === 'approved') {
            $updateData['approved_by'] = auth()->id();
            $updateData['approved_at'] = now();
            $updateData['completed_at'] = null;
        }

        if ($newStatus === 'completed') {
            $updateData['completed_at'] = now();

            if (!$activity->approved_by) {
                $updateData['approved_by'] = auth()->id();
            }

            if (!$activity->approved_at) {
                $updateData['approved_at'] = now();
            }
        }

        if (in_array($newStatus, ['revision', 'rejected'])) {
            $updateData['approved_by'] = null;
            $updateData['approved_at'] = null;
            $updateData['completed_at'] = null;
        }

        $activity->update($updateData);

        ActivityStatusLog::create([
            'activity_id' => $activity->id,
            'changed_by' => auth()->id(),
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'note' => $validated['note'] ?? 'Status aktivitas diperbarui melalui halaman review.',
        ]);

        if (!empty($validated['note'])) {
            ActivityComment::create([
                'activity_id' => $activity->id,
                'user_id' => auth()->id(),
                'comment' => $validated['note'],
                'comment_type' => $newStatus,
            ]);
        }

        return redirect()
            ->route('activities.show', $activity)
            ->with('success', 'Review aktivitas berhasil disimpan.');
    }
}
