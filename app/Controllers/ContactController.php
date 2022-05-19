<?php

namespace App\Controllers;

use App\Core\Request;

class ContactController
{
    public function index()
    {
        return view('contact');
    }
    public function register(Request $request)
    {
        dd($request);
    }
}
