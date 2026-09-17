<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'activity_id',
        'uploaded_by',
        'original_name',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
        'file_type',
        'description',
        'drive_file_id',
        'drive_url',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
