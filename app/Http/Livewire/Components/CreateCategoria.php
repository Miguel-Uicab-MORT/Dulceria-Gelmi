<?php

namespace App\Http\Livewire\Components;

use App\Models\Categoria;
use Livewire\Component;

class CreateCategoria extends Component
{
    public $create = false;
    public $statusList;
    public $name, $status;

    protected $rules = [
        'name' => 'required',
        'status' => 'required'
    ];

    public function create()
    {
        if ($this->create == false) {
            $this->create = true;
        } else {
            $this->create = false;
            $this->reset(['name', 'status']);
        }
    }

    public function store()
    {
        $this->validate();

        $categoria = new Categoria();

        $categoria->name = $this->name;
        $categoria->status = $this->status;

        $categoria->save();
        $this->reset(['name', 'status', 'create']);
        $this->emit('render');
    }

    public function mount()
    {
        $this->statusList = ['1' => 'Activo', '2' => 'Inactivo'];
    }

    public function render()
    {
        return view('livewire.components.create-categoria');
    }
}
