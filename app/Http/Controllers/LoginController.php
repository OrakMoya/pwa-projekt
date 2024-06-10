<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller {
    public function show(): Response {
        return Inertia::render('Login');
    }

    public function store(LoginRequest $request): Redirector|RedirectResponse {
        $validated = $request->validated();
        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password']
        ];

        if (Auth::attempt($credentials, $request->rememberme)) {
            $request->session()->regenerate();
            return redirect('/admin');
        }

        return back()->withErrors(
            ['password' => 'Incorrect email or password']
        );
    }

    public function discard(Request $request): Redirector|RedirectResponse {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/');
    }
}
