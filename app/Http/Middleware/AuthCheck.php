<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    /**
     * Не позволяет не аутентифицированному пользователю заходить на страницу '/dashboard'
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Session()->has('loginId')) {
            return redirect()->route('login')->with('error', 'Войдите в свой аккаунт.');
        }
        return $next($request);
    }
}
