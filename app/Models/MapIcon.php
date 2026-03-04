<?php

namespace App\Models; // Lives under app/Models so Laravel auto-loads it

use Illuminate\Database\Eloquent\Model; // Base Eloquent ORM class

class MapIcon extends Model
{
    /**
     * ====== Mass assignment ======
     * Defines which attributes can be bulk-assigned via create(), update(), etc.
     *
     * @var list<string>
     */
    protected $fillable = [
        'war_id',          // ID of the war this icon belongs to
        'shard',           // Which shard this icon belongs to (able/baker)
        'map_name',        // Name of the map this icon is placed on
        'team_id',         // Faction/team owning this icon (e.g., Warden, Colonial)
        'icon_type',       // Type/category of the icon (e.g., base, relic base, refinery)
        'x',               // X coordinate on the map
        'y',               // Y coordinate on the map
        'flags',           // Special state/flags for the icon (bitmask or numeric)
        'version',         // Data version for this map icon
        'last_updated_ms', // Last updated time in milliseconds since epoch
    ];

    /**
     * ====== Attribute casting ======
     * Automatically cast attributes to specific types.
     */
    protected $casts = [
        'x' => 'float', // Ensures X coordinate is always stored/retrieved as float
        'y' => 'float', // Ensures Y coordinate is always stored/retrieved as float
    ];
}
