<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class SignupController extends Controller
{
    public function show(): Response{
        return Inertia::render("Signup");
    }

    public function store(SignupRequest $request): RedirectResponse{
        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect('login')->with('status', 'Signup complete!');
    }
}
