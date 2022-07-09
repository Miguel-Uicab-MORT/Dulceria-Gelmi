<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;

class Client extends Component
{

    use WithPagination;

    public $search;
    public $edit = false;
    public $type_search = 1;
    public $selectSearch = 'businessname';
    public $cliente;
    public $typePerson = [
        'Persona Fisica',
        'Persona Moral',
    ];

    protected $listeners = ['render' => 'render', 'delete'];

    protected $rules = [
        'cliente.businessname' => 'required',
        'cliente.email' => 'required',
        'cliente.typePerson' => 'required',
        'cliente.rfc' => 'required',
        'cliente.cp' => 'required',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedTypeSearch($value)
    {
        if ($value == 1) {
            $this->selectSearch = "businessname";
            $this->search = "";
        } elseif ($value == 2) {
            $this->selectSearch = "rfc";
            $this->search = "";
        } elseif ($value == 3) {
            $this->selectSearch = "email";
            $this->search = "";
        }
    }

    public function edit(Cliente $cliente)
    {
        $this->cliente = $cliente;
        $this->validate();

        if ($this->edit == false) {
            $this->edit = true;
        } elseif ($this->edit == true) {
            $this->edit = false;
            $this->reset(['cliente']);
        }
    }

    public function update()
    {
        $this->validate();

        $this->cliente->save();

        $this->edit = false;

        $this->emit('render');
        $this->emit('alert', 'Los datos del cliente se actualizaron correctamente');
    }

    public function delete(Cliente $cliente)
    {
        $cliente->delete();
    }

    public function render()
    {
        $clientes = Cliente::where($this->selectSearch, 'LIKE', '%' . $this->search . '%')
            ->orderBy($this->selectSearch, 'Desc')
            ->paginate('15');

        return view('livewire.client', compact('clientes'));
    }
}
