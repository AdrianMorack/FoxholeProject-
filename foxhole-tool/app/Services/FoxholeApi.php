<?php

namespace App\Services; // lives in the Services folder

use Illuminate\Support\Facades\Http; // Laravel HTTP client
use App\Models\ApiEtag;               // DB model for storing API ETag data

class FoxholeApi
{
    // Base URL for the official Foxhole War Service API
    private string $base = 'https://war-service-live.foxholeservices.com/api';

    // Generic GET request wrapper that also handles ETag caching
    private function getWithEtag(string $path, string $etagKey): ?array
    {
        // Either get existing ETag record or make one if it doesn't exist
        $etag = ApiEtag::firstOrCreate(['endpoint' => $etagKey]);

        // Prepare request headers (empty unless we have a stored ETag)
        $headers = [];
        if ($etag->etag) {
            // Send If-None-Match to tell API "only give me new data"
            $headers['If-None-Match'] = $etag->etag;
        }

        // Make the HTTP GET request with optional headers and 20s timeout
        $resp = Http::withHeaders($headers)
                    ->timeout(20)
                    ->get("{$this->base}{$path}");

        // If API says 304 Not Modified → data hasn't changed
        if ($resp->status() === 304) {
            // Track when we last got a 304
            $etag->last_http_304_at = now();
            $etag->save();
            return null; // no update needed
        }

        // Throw exception if response is error (4xx / 5xx)
        $resp->throw();

        // If API gave us a new ETag, store it
        if ($new = $resp->header('ETag')) {
            $etag->etag = $new;
        }

        // Track when we last got a fresh 200 response
        $etag->last_http_200_at = now();
        $etag->save();

        // Return JSON response as PHP array
        return $resp->json();
    }

    // ===== Public helper methods for specific API endpoints =====

    // Get global war state
    public function war(): ?array
    {
        return $this->getWithEtag('/worldconquest/war', 'war');
    }

    // Get list of maps
    public function maps(): ?array
    {
        return $this->getWithEtag('/worldconquest/maps', 'maps');
    }

    // Get war report for a specific map
    public function warReport(string $map): ?array
    {
        return $this->getWithEtag("/worldconquest/warReport/{$map}", "warReport:{$map}");
    }

    // Get dynamic (live) map data for a specific map
    public function dynamic(string $map): ?array
    {
        return $this->getWithEtag("/worldconquest/maps/{$map}/dynamic/public", "dynamic:{$map}");
    }
}
