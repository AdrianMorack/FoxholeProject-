<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetShardFromRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get shard from route parameter
        $shard = $request->route('shard');
        
        // Validate and set session
        if ($shard && in_array($shard, ['able', 'baker'])) {
            session(['foxhole_shard' => $shard]);
        }
        
        return $next($request);
    }
}
