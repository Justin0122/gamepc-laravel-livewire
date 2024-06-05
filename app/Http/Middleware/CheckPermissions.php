<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermissions
{
    public function handle($request, Closure $next, $permission)
    {
        if (Auth::check() && Auth::user()->can($permission)) {
            return $next($request);
        }

        return redirect()->route('dashboard');
    }
}
