<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user() && $request->is('login')) {
            return redirect()->route('customer.dashboard');
        }

        if (Auth::guard('admin')->user() && $request->is('login-admin')) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
