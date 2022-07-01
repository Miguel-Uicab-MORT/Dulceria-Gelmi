<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use Livewire\Component;
use Livewire\WithPagination;

class Category extends Component
{
    use WithPagination;

    public $search;
    public $categoria, $statusList;
    public $edit = false;

    protected $listeners = ['render' => 'render'];

    protected $rules = [
        'categoria.name' => 'required',
        'categoria.status' => 'required',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function edit(Categoria $categoria)
    {
        $this->categoria = $categoria;
        $this->validate();

        if ($this->edit == false) {
            $this->edit = true;
        } elseif ($this->edit == true) {
            $this->edit = false;
            $this->reset(['categoria']);
        }
    }

    public function update()
    {
        $this->validate();

        $this->categoria->save();

        $this->edit = false;

        $this->emit('render');
    }

    public function delete(Categoria $categoria)
    {
        $this->categoria = $categoria;
        $this->categoria->delete();
        $this->render();
    }

    public function mount()
    {
        $this->statusList = ['1' => 'Activo', '2' => 'Inactivo'];
    }

    public function render()
    {
        $categorias = Categoria::where('name', 'LIKE', '%' . $this->search . '%')
            ->orderBy('name', 'Desc')->paginate('15');

        return view('livewire.category', compact('categorias'));
    }
}
