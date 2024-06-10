<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Auth;
use Hash;

use function Termwind\render;

class AdminUserController extends Controller {
    public function show(): Response {
        $users = User::select('id', 'name', 'email')->get();
        $current_user = Auth::user()->email;
        return Inertia::render('Admin/Users', ['users' => $users, 'current_user' => $current_user]);
    }

    public function deleteUser(DeleteUserRequest $request): RedirectResponse {
        $id = $request->validated()['id'];
        User::destroy($id);
        return redirect()->back()->with('status', 'User deleted!');
    }

    public function updateUser(UpdateUserRequest $request): RedirectResponse {
        $validated = $request->validated();
        User::updateOrCreate(['id' => $validated['id']], $validated);
        return redirect()->back()->with('status', 'User updated!');
    }

    public function updateUserPassword(UpdateUserPasswordRequest $request) {
        $validated = $request->validated();
        $user = User::updateOrCreate(['id' => $validated['id']], ['password' => Hash::make($validated['password'])]);
        return redirect()->back()->with('status', 'Password saved!');
    }
}
