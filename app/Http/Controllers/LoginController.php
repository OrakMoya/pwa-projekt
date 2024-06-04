<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function show()
    {
        return Inertia::render('Login');
    }

    public function store(LoginRequest $request)
    {
        $validated = $request->validated();
        $credentials = ["email" => $validated['email'], 'password' => $validated['password']];
        if (Auth::attempt($credentials, $request->rememberme)) {
            $request->session()->regenerate();
            return Inertia::location('/admin');
        }

        return back()->withErrors(['password' => 'Incorrect email or password']);
    }

    public function discard(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return Inertia::location('/');
    }
}
