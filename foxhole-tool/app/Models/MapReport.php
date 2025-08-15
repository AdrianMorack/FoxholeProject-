<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapReport extends Model
{
    protected $fillable = [
        'map_name','total_enlistments','colonial_casualties',
        'warden_casualties','day_of_war','fetched_at'
    ];

    protected $casts = [
        'fetched_at' => 'datetime',
    ];
}
