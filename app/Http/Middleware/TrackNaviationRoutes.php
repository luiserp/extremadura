<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackNaviationRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->method() !== 'GET') {
            return $next($request);
        }

        $previous = $request->session()->get('previous');

        if ($previous) {
            $request->session()->put('pre_previous', $previous);
        }

        $request->session()->put('previous', url()->previous());

        return $next($request);
    }
}
