<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    protected $fillable = ['name','region_id','last_updated_ms','version'];
}
