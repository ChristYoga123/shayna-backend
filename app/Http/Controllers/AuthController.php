<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view("layouts.guest");
    }

    public function login(Request $request)
    {
    }
}
