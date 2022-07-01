<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class CreateUser extends Component
{
    public $create = false;

    public function create()
    {
        if ($this->create == false) {
            $this->create = true;
        } else {
            $this->create = false;
            //$this->reset(['categoria_id', 'name', 'slug', 'description', 'cost', 'price', 'stock', 'status', 'barcode']);
        }
    }

    public function render()
    {
        return view('livewire.components.create-user');
    }
}
