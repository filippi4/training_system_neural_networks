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
                return redirect('dashboard')->with('success', 'Вы успешно вошли');
            } else {
                return back()->with('error', 'Неверный пароль');
            }
        } else {
            return back()->with('error', 'Email адрес не зарегистрирован');
        }

    }

    public function logout() {
        if (Session::has('loginId')) {
            Session::pull('loginId');
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
            return redirect('dashboard')->with('success', 'Вы успешно зарегистрировались');
        } else {
            return back()->with('error', 'Ошибка регистрации');
        }
    }

    public function dashboard() {
        $data = [];
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
            return view('auth.dashboard', compact('data'));
        }
    }
}
