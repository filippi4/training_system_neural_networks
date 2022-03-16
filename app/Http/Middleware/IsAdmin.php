<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Session;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    /**
     * Доступ к панели администратора по адресу '/admin'
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('loginId')) {
            $user = User::where('id', '=', Session::get('loginId'))->first();
            if ($user->is_admin == 1)
                return $next($request);
        } else {
            return back()->with('error', 'Войдите в аккаунт администратора.');
        }
        return back()->with('error', 'Вы не являетесь администратором.');
    }
}
