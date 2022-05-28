<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;

class ContactController extends Controller
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
