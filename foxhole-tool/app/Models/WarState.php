<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarState extends Model
{
    protected $fillable = [
        'war_id','war_number','winner','conquest_start','conquest_end',
        'resistance_start','scheduled_conquest_end',
        'required_victory_towns','short_required_victory_towns',
    ];

    protected $casts = [
        'conquest_start' => 'datetime',
        'conquest_end' => 'datetime',
        'resistance_start' => 'datetime',
        'scheduled_conquest_end' => 'datetime',
    ];
}