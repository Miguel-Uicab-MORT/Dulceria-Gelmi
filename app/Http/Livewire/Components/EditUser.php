<?php

namespace App\Http\Livewire\Components;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EditUser extends Component
{
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function listUsers()
    {
        return redirect()->route('users.index');
    }

    public function render()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('livewire.components.edit-user', compact('roles', 'permissions'));
    }
}
