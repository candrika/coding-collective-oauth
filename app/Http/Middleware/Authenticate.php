<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    // protected function redirectTo($request)
    // {
    //     if (!$request->expectsJson()) {
    //         return route('redirect');
    //     }
    // }
    public function handle($request, Closure $next, ...$guards)
    {
        if (!$request->expectsJson()) {
            $is_exists = Auth::guard('api')->user();

            if ($is_exists) {
                return $next($request);
            }

            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
