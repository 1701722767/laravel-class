<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAccessPath
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
        $user = auth('api')->user();
        if (!$user) {
            return response()->json(['message' => 'you do not have permission to access for this page'], 401);
        }

        $originalPath = $request->path();
        $pattern      = '/(\/)(\d+)(\/?)/';
        $replacement  = '$1#$3';
        $templatePath = preg_replace($pattern, $replacement, $originalPath);

        $method  = $request->method();
        $permits = $user->role->permissions()->where('method', $method)->where('url', $originalPath)->orWhere('url', $templatePath)->count();
        if ($permits <= 0) {
            return response()->json(['message' => 'you do not have permission to access for this page'], 401);
        }

        return $next($request);
    }
}
