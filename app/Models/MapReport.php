<?php

namespace App\Models; // Lives under app/Models so Laravel auto-loads it

use Illuminate\Database\Eloquent\Model; // Base Eloquent ORM class

class MapReport extends Model
{
    /**
     * ====== Mass assignment ======
     * Defines which attributes can be bulk-assigned via create(), update(), etc.
     *
     * @var list<string>
     */
    protected $fillable = [
        'map_name',            // The name of the map this report belongs to
        'shard',               // Which shard this report belongs to (able/baker)
        'total_enlistments',   // Total number of enlistments on this map
        'colonial_casualties', // Casualties for the Colonial faction
        'warden_casualties',   // Casualties for the Warden faction
        'day_of_war',          // The day number of the war for this report
        'fetched_at',          // Timestamp when the report was fetched
    ];

    /**
     * ====== Attribute casting ======
     * Automatically cast attributes to specific types.
     */
    protected $casts = [
        'fetched_at' => 'datetime', // Casts fetched_at to a Carbon date/time instance
    ];
}
