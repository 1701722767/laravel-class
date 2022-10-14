<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth('api')->user()) {
            return response()->json(['message' => 'you do not have permission to access for this page'], 401);
        }

        $user = auth('api')->user();
        error_log('usuario>' . $user);
        error_log('id>' . $user->id);
        return $next($request);

    }
}
