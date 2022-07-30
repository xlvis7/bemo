<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTokenAndAddToHeader
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->get('access_token');
        if ($token) {
            $request->headers->set('Authorization', sprintf('%s %s', 'Bearer', $token));
        }
        return $next($request);
    }
}
