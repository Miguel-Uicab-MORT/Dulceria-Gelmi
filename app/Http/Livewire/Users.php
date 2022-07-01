<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $search;
    public $user;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete(User $user)
    {
        $this->user = $user;
        $this->user->delete();
        $this->render();
    }

    public function edit(User $user)
    {
        redirect()->route('users.edit', $user);
    }

    public function render()
    {
        $users = User::where('name', 'LIKE', '%' . $this->search . '%')
        ->orWhere('email', 'LIKE', '%' . $this->search . '%')
        ->paginate();

        return view('livewire.users', compact('users'));
    }
}
