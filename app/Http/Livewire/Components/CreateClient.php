<?php

namespace App\Http\Livewire\Components;

use App\Models\Cliente;
use Livewire\Component;

class CreateClient extends Component
{
    public $create = false;
    public $businessname, $email, $personType, $rfc, $cp;
    public $typePerson = [
        'Persona Fisica',
        'Persona Moral',
    ];

    protected $rules = [
        'businessname' => 'required',
        'email' => 'required|email',
        'typePerson' => 'required',
        'rfc' => 'required|unique:clientes,rfc',
        'cp' => 'required',
    ];

    public function create()
    {
        if ($this->create == false) {
            $this->create = true;
        } else {
            $this->create = false;
            $this->reset(['businessname','email','personType','cp', 'rfc']);
        }
    }

    public function store()
    {
        $rules = $this->rules;

        $this->validate($rules);

        $cliente = new Cliente();

        $cliente->businessname = $this->businessname;
        $cliente->email = $this->email;
        $cliente->typePerson = $this->personType;
        $cliente->rfc = $this->rfc;
        $cliente->cp = $this->cp;

        $cliente->save();
        $this->reset(['businessname','email','personType','cp', 'rfc', 'create']);
        $this->emit('render');
        $this->emit('alert', 'Los datos del cliente se agregaron correctamente');
    }

    public function render()
    {
        return view('livewire.components.create-client');
    }
}
