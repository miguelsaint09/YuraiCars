<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ForceHttps
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->secure() && app()->environment('production')) {
            // Force HTTPS on all assets
            URL::forceScheme('https');
            
            // Redirect to HTTPS if accessed via HTTP
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
} 