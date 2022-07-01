<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    use WithPagination;

    public $search, $role;
    public $name, $permisos = [];
    protected $rules = ['name' => 'required'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function Store()
    {
        $this->validate();

        $role = new Role();
        $role->name = $this->name;
        $role->save();

        $role->permissions()->sync($this->permisos);
        $this->reset(['name', 'permisos']);

    }

    public function delete(Role $role)
    {
        $this->role = $role;
        $this->role->delete();
        $this->render();
    }

    public function render()
    {
        $roles = Role::where('name', 'LIKE', '%' . $this->search . '%')->paginate();
        $permissions = Permission::all();

        return view('livewire.roles', compact('roles', 'permissions'));
    }
}
