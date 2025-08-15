<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\ApiEtag;

class FoxholeApi
{
    private string $base = 'https://war-service-live.foxholeservices.com/api';

    private function getWithEtag(string $path, string $etagKey): ?array
    {
        $etag = ApiEtag::firstOrCreate(['endpoint' => $etagKey]);

        $headers = [];
        if ($etag->etag) {
            $headers['If-None-Match'] = $etag->etag;
        }

        $resp = Http::withHeaders($headers)->timeout(20)->get("{$this->base}{$path}");

        if ($resp->status() === 304) {
            $etag->last_http_304_at = now();
            $etag->save();
            return null; // unchanged
        }

        $resp->throw(); // 4xx/5xx → exception

        if ($new = $resp->header('ETag')) {
            $etag->etag = $new;
        }
        $etag->last_http_200_at = now();
        $etag->save();

        return $resp->json();
    }

    public function war(): ?array
    {
        return $this->getWithEtag('/worldconquest/war', 'war');
    }

    public function maps(): ?array
    {
        return $this->getWithEtag('/worldconquest/maps', 'maps');
    }

    public function warReport(string $map): ?array
    {
        return $this->getWithEtag("/worldconquest/warReport/{$map}", "warReport:{$map}");
    }

    public function dynamic(string $map): ?array
    {
        return $this->getWithEtag("/worldconquest/maps/{$map}/dynamic/public", "dynamic:{$map}");
    }
}
