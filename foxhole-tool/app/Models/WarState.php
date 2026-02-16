<?php

namespace App\Models; // Lives in app/Models so Laravel auto-loads it

use Illuminate\Database\Eloquent\Model; // Base Eloquent model class

class WarState extends Model
{
    // ====== Mass assignment settings ======
    // $fillable = fields we allow to be bulk-assigned in create() or update()
    protected $fillable = [
        'war_id',                  // UUID for this war from Foxhole API
        'war_number',              // Sequential war number
        'winner',                   // Which faction won (e.g., WARDENS / COLONIALS / NONE)
        'conquest_start',           // When the Conquest phase started
        'conquest_end',             // When the Conquest phase ended
        'resistance_start',         // When Resistance phase started
        'scheduled_conquest_end',   // Planned end date (can differ from actual)
        'required_victory_towns',   // Total towns needed for victory
        'short_required_victory_towns', // Shorter victory condition value
        'shard',                    // Which shard this war belongs to (able/baker)
    ];

    // ====== Type casting ======
    // $casts tells Laravel to automatically convert these fields into Carbon datetime objects
    protected $casts = [
        'conquest_start'         => 'datetime',
        'conquest_end'           => 'datetime',
        'resistance_start'       => 'datetime',
        'scheduled_conquest_end' => 'datetime',
    ];
}
