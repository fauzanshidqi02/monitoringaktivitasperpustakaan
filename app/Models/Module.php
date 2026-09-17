<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function activityCategories(): HasMany
    {
        return $this->hasMany(ActivityCategory::class);
    }
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}
