<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ActivityFileController extends Controller
{
    public function store(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,ppt,pptx',
                'max:20480',
            ],
            'file_type' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
        ]);

        $uploadedFile = $request->file('file');

        $originalName = $uploadedFile->getClientOriginalName();
        $extension = $uploadedFile->getClientOriginalExtension();

        $fileName = now()->format('YmdHis') . '_' . Str::random(10) . '.' . $extension;

        $folderPath = 'activity-files/' . now()->format('Y/m');

        $filePath = $uploadedFile->storeAs(
            $folderPath,
            $fileName,
            'public'
        );

        ActivityFile::create([
            'activity_id' => $activity->id,
            'uploaded_by' => auth()->id(),
            'original_name' => $originalName,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'mime_type' => $uploadedFile->getClientMimeType(),
            'file_size' => $uploadedFile->getSize(),
            'file_type' => $validated['file_type'] ?? null,
            'description' => $validated['description'] ?? null,
            'drive_file_id' => null,
            'drive_url' => null,
        ]);

        return redirect()
            ->route('activities.show', $activity)
            ->with('success', 'Bukti aktivitas berhasil diupload.');
    }

    public function destroy(ActivityFile $activityFile)
    {
        $activity = $activityFile->activity;

        if ($activityFile->file_path && Storage::disk('public')->exists($activityFile->file_path)) {
            Storage::disk('public')->delete($activityFile->file_path);
        }

        $activityFile->delete();

        return redirect()
            ->route('activities.show', $activity)
            ->with('success', 'Bukti aktivitas berhasil dihapus.');
    }
}
