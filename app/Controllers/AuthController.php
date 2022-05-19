<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\Register;

class AuthController
{
    public function login(Request $request)
    {
        if ($request->isPost()) {
            // $request->getBody();
            // dd($request);
            $validated = $request->validate([
                'first_name' => 'required|string|min:3',
                'lastname' => 'required|string|max:255',
                'email' => 'required|email',
                'password' => 'required|same:password_confirmation',
                'password_confirmation' => 'required',
            ]);
            // dd($request);
            // return '';
        }
        return view('auth.login');
    }
    public function register(Request $request)
    {
        $register = new Register();
        if ($request->isPost()) {
            $register = $register->create($request->all());
            // $request->getBody();
            $validated = $request->validate([
                'firstname' => 'required|string|min:3',
                'lastname' => 'required|string|max:255',
                'email' => 'required|email',
                'password' => 'required|same:password_confirmation',
                'password_confirmation' => 'required',
            ]);
        }
        return view('auth.register');
    }
}
