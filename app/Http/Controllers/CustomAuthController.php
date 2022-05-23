<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Session;

class CustomAuthController extends Controller
{
    public function login() {
        return view('auth.login');
    }

    public function loginUser(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|max:12'
        ]);

        $user = User::where('email', '=', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('loginId', $user->id);
                // ** 
                // костыль
                // не работает yield('user-name') в файле nav.blade.php, 
                // с секцией section('user-name') в dashboard.blade.php
                $request->session()->put('userName', $user->name);
                // **
                if ($user->is_admin == 1) {
                    return redirect('dashboard')->with('success', 'Вы успешно вошли в аккаунт администратора.');
                }
                else {
                    return redirect('dashboard')->with('success', 'Вы успешно вошли в аккаунт.');
                }
            } else {
                return back()->with('error', 'Неверный пароль.');
            }
        } else {
            return back()->with('error', 'Email адрес не зарегистрирован.');
        }

    }

    public function logout() {
        /**
         * BUG: если после выхода пользователя, регистрируется новый пользователь, 
         * то на панели навигации отображается имя вышедшего пользователя
         */
        if (Session::has('loginId')) {
            Session::forget('loginId');
            return redirect()->route('login');
        }
    }

    public function registration() {
        return view('auth.registration');
    }

    public function registerUser(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:12'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        if ($user) {
            $request->session()->put('loginId', $user->id);
            return redirect('dashboard')->with('success', 'Вы успешно зарегистрировались.');
        } else {
            return back()->with('error', 'Ошибка регистрации.');
        }
    }

    public function dashboard() {
        $data = [];
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
            // В зависимости от права открывает административную панель или панель обычного пользователя
            if ($data->is_admin == 1) {
                return view('auth.admin.dashboard', compact('data'));                
            }
            else {
                return view('auth.dashboard', compact('data'));                
            }
        }
    }
}
