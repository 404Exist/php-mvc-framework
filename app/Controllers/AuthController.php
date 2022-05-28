<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Facades\Auth;
use App\Core\Request;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(new AuthMiddleware())->except('login', 'register');
        $this->middleware(new GuestMiddleware())->only('login', 'register');
    }

    public function login(Request $request)
    {
        if ($request->isPost()) {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            session()->flash('success', 'user logged in successfully');
            return redirect('/profile');
        }
        return view('auth.login');
    }
    
    public function register(Request $request)
    {
        if ($request->isPost()) {
            $request->validate([
                'firstname' => 'required|string|min:3',
                'lastname' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|same:password_confirmation',
                'password_confirmation' => 'required',
            ]);
            (new User())->save($request->all());
            session()->flash('success', 'user created successfully');
            return redirect('/');
        }
        return view('auth.register');
    }

    public function logout()
    {
        Auth::logout();
        session()->flash('success', 'user loggedout successfully');
        return redirect('/');
    }

    public function profile()
    {
        return view('auth.profile');
    }
}
