<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Map extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'maps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'shard',
        'region_id',
        'last_updated_ms',
        'version',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'region_id' => 'integer',
        'last_updated_ms' => 'integer',
        'version' => 'integer',
    ];

    /**
     * Get all map reports for this map.
     *
     * @return HasMany
     */
    public function reports(): HasMany
    {
        return $this->hasMany(MapReport::class, 'map_name', 'name');
    }

    /**
     * Get all map icons for this map.
     *
     * @return HasMany
     */
    public function icons(): HasMany
    {
        return $this->hasMany(MapIcon::class, 'map_name', 'name');
    }

    /**
     * Get the latest report for this map.
     *
     * @return MapReport|null
     */
    public function latestReport(): ?MapReport
    {
        return $this->reports()->latest('fetched_at')->first();
    }

    /**
     * Scope a query to only include maps with recent updates.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $minutes
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecentlyUpdated($query, int $minutes = 60)
    {
        return $query->where('updated_at', '>=', now()->subMinutes($minutes));
    }
}
