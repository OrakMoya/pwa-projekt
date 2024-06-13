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

class AdminUserController extends Controller
{
    public function show(): Response
    {
        $users = User::select('id', 'name', 'email', 'read_only', 'privilege_level')->get();
        $available_privileges = ['administrator', 'editor'];
        $current_user = [
            'email' => Auth::user()->email,
            'privilege_level' => Auth::user()->privilege_level
        ];
        return Inertia::render('Admin/Users', ['users' => $users, 'current_user' => $current_user, 'available_privileges' => $available_privileges]);
    }

    public function deleteUser(DeleteUserRequest $request): RedirectResponse
    {
        $id = $request->validated()['id'];

        if ($id != Auth::id() && Auth::user()->privilege_level != 'administrator') {
            return redirect()->back()->withErrors(['privilege_level' => 'Only administrators can edit other users!']);
        }
        if (User::find($id)->read_only) {
            return redirect()->back()->withErrors(['user' => 'This user is read only!']);
        }

        User::destroy($id);
        return redirect()->back()->with('status', 'User deleted!');
    }

    public function updateUser(UpdateUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $id = $validated['id'];
        $updated_user = User::find($id);

        if ($updated_user->read_only) {
            return redirect()->back()->withErrors(['user' => 'This user is read only!']);
        }
        if ($validated['privilege_level'] && $validated['privilege_level'] != $updated_user->privilege_level && Auth::user()->privilege_level != 'administrator') {
            return redirect()->back()->withErrors(['privilege_level' => 'Only an administrator can change the privilege level!']);
        }
        if ($id != Auth::id() && Auth::user()->privilege_level != 'administrator') {
            return redirect()->back()->withErrors(['privilege_level' => 'Only administrators can edit other users!']);
        }

        User::updateOrCreate(['id' => $id], $validated);
        return redirect()->back()->with('status', 'User updated!');
    }

    public function updateUserPassword(UpdateUserPasswordRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $id = $validated['id'];

        if (User::find($id)->read_only) {
            return redirect()->back()->withErrors(['user' => 'This user is read only!']);
        }
        if ($id != Auth::id() && Auth::user()->privilege_level != 'administrator') {
            return redirect()->back()->withErrors(['privilege_level' => 'Only administrators can edit other users!']);
        }

        $user = User::updateOrCreate(['id' => $id], ['password' => Hash::make($validated['password'])]);
        return redirect()->back()->with('status', 'Password saved!');
    }
}
