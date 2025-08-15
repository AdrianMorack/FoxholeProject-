<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiEtag extends Model
{
    protected $fillable = ['endpoint','etag','last_http_200_at','last_http_304_at'];

    protected $casts = [
        'last_http_200_at' => 'datetime',
        'last_http_304_at' => 'datetime',
    ];
}