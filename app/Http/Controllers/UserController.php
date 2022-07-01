<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function updateRole(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);

        return redirect()->route('users.edit', $user);
    }

    public function updatePermission(Request $request, User $user)
    {
        $user->permissions()->sync($request->permissions);

        return redirect()->route('users.edit', $user);
    }
}
