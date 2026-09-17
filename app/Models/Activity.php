<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'module_id',
        'activity_category_id',
        'created_by',
        'assigned_to',
        'title',
        'description',
        'activity_date',
        'quantity',
        'unit',
        'status',
        'input_source',
        'evidence_required',
        'notes',
        'approved_at',
        'completed_at',
    ];

    protected $casts = [
        'activity_date' => 'date',
        'evidence_required' => 'boolean',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ActivityCategory::class, 'activity_category_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

     public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(ActivityStatusLog::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(ActivityFile::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ActivityComment::class);
    }
}
