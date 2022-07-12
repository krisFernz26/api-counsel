<?php

namespace App\Http\Middleware;

use Closure;

class CustomCORSHandler
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
}
