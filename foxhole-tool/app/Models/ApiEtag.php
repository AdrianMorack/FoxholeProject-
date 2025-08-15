<?php

namespace App\Models; // Lives under app/Models so Laravel auto-loads it

use Illuminate\Database\Eloquent\Model; // Base Eloquent ORM class

class ApiEtag extends Model
{
    /**
     * ====== Mass assignment ======
     * Defines which attributes can be bulk-assigned via create(), update(), etc.
     *
     * @var list<string>
     */
    protected $fillable = [
        'endpoint',        // Unique identifier for the API endpoint (e.g., 'war', 'maps')
        'etag',            // Last known ETag from API response, used for caching
        'last_http_200_at',// Timestamp of last successful 200 OK response
        'last_http_304_at',// Timestamp of last 304 Not Modified response
    ];

    /**
     * ====== Attribute casting ======
     * Automatically converts timestamps to Carbon instances.
     */
    protected $casts = [
        'last_http_200_at' => 'datetime', // Cast last 200 OK timestamp to Carbon
        'last_http_304_at' => 'datetime', // Cast last 304 Not Modified timestamp to Carbon
    ];
}
