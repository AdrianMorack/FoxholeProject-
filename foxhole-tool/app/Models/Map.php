<?php

namespace App\Models; // Lives under app/Models so Laravel auto-loads it

use Illuminate\Database\Eloquent\Model; // Base Eloquent ORM class

class Map extends Model
{
    /**
     * ====== Mass assignment ======
     * Defines which attributes can be bulk-assigned via create(), update(), etc.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',            // Name of the map (e.g., AcrithiaHex)
        'region_id',       // Optional ID representing the map's region or grouping
        'last_updated_ms', // Last updated timestamp in milliseconds since epoch
        'version',         // Version of the map data
    ];
}
