<?php

namespace App\Http\Livewire\Components;

use App\Models\Cliente;
use Livewire\Component;

class CreateClient extends Component
{
    public $create = false;
    public $name, $lastname, $businessname, $number, $email, $personType, $rfc, $cp, $state, $municipality, $city, $colony, $address;
    public $typePerson = [
        'Persona Fisica',
        'Persona Moral',
    ];

    protected $rules = [
        'name' => 'required',
        'lastname' => 'required',
        'businessname' => 'required',
        'number' => 'required',
        'email' => 'required|email',
        'typePerson' => 'required',
        'rfc' => 'required|unique:clientes,rfc',
        'cp' => 'required',
        'state' => 'required',
        'city' => 'required',
        'colony' => 'required',
        'address' => 'required',
    ];

    public function create()
    {
        if ($this->create == false) {
            $this->create = true;
        } else {
            $this->create = false;
            $this->reset(['name','lastname','businessname','number','email','personType','cp','state','municipality','city','colony','address']);
        }
    }

    public function store()
    {
        $rules = $this->rules;

        $this->validate($rules);

        $cliente = new Cliente();

        $cliente->name = $this->name;
        $cliente->lastname = $this->lastname;
        $cliente->businessname = $this->businessname;
        $cliente->number = $this->number;
        $cliente->email = $this->email;
        $cliente->typePerson = $this->personType;
        $cliente->rfc = $this->rfc;
        $cliente->cp = $this->cp;
        $cliente->state = $this->state;
        $cliente->city = $this->city;
        $cliente->colony = $this->colony;
        $cliente->address = $this->address;

        $cliente->save();
        $this->reset(['name','lastname','businessname','number','email','personType','cp','state','municipality','city','colony','address', 'create']);
        $this->emit('render');
    }

    public function render()
    {
        return view('livewire.components.create-client');
    }
}
