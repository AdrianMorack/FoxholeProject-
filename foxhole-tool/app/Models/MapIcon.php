<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapIcon extends Model
{
    protected $fillable = [
        'war_id','map_name','team_id','icon_type','x','y','flags','version','last_updated_ms'
    ];

    protected $casts = [
        'x' => 'float',
        'y' => 'float',
    ];
}