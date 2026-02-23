<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapTextItem extends Model
{
    protected $fillable = [
        'shard',
        'war_id',
        'map_name',
        'text',
        'x',
        'y',
        'map_marker_type',
    ];

    protected $casts = [
        'x' => 'float',
        'y' => 'float',
    ];
}
