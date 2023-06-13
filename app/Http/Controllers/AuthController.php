<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view("layouts.guest");
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        if (Auth::attempt(["email" => $request->email, "password" => $request->password])) {
            // check role
            if ($this->isAdmin()) {
                return redirect()->route("admin.dashboard.index")->with("success", "Login berhasil");
            }

            return redirect()->back()->with("error", "Maaf! Anda dilarang masuk halaman ini");
        }

        return redirect()->back()->with("error", "Maaf! Akun atau password belum terdaftar");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route("admin.login.index");
    }

    private function isAdmin()
    {
        return Auth::check() && Auth::user()->role === "Admin";
    }
}
