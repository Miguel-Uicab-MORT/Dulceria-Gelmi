<?php

namespace App\Http\Livewire;

use App\Exports\BarcodeExport;
use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Inventory extends Component
{
    use WithPagination;

    public $search;
    public $producto, $statusList, $barcode;
    public $edit = false;
    public $type_search = 1;
    public $selectSearch = 'id';

    protected $listeners = ['render' => 'render', 'delete'];

    protected $rules = [
        'producto.barcode' => 'required',
        'producto.name' => 'required',
        'producto.key_product' => 'required',
        'producto.stock' => 'required',
        'producto.cost' => 'required',
        'producto.price' => 'required',
        'producto.status' => 'required',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedTypeSearch($value)
    {
        if ($value == 1) {
            $this->selectSearch = "id";
            $this->search = "";
        } elseif ($value == 2) {
            $this->selectSearch = "barcode";
            $this->search = "";
        }elseif ($value == 3) {
            $this->selectSearch = "name";
            $this->search = "";
        }
    }

    public function edit(Producto $producto)
    {
        $this->producto = $producto;
        $this->barcode = $this->producto->barcode;
        $this->validate();

        if ($this->edit == false) {
            $this->edit = true;
        } elseif ($this->edit == true) {
            $this->edit = false;
            $this->reset(['producto']);
        }
    }

    public function update()
    {
        $this->validate();

        $this->producto->save();

        $this->edit = false;

        $this->emit('render');
        $this->emit('alert', 'El producto se actualizo correctamente');
    }

    public function delete(Producto $producto)
    {
        $this->producto = $producto;
        $this->producto->delete();
        $this->render();
    }

    public function mount()
    {
        $this->statusList = ['1' => 'Activo', '2' => 'Inactivo'];
        $this->keys_products = [
            '50161813' => '50161813 - Chocolate o sustituto de chocolate, confite',
            '50161814' => '50161814 - Azúcar o sustituto de azúcar, confite (Gomitas)',
            '50161815' => '50161815 - Goma de mascar',
            '50161800' => '50161800 - Dulces de confite'
        ];
    }

    public function printLabels()
    {
        return Excel::download(new BarcodeExport, 'labels.csv');
    }

    public function render()
    {
        $productos = Producto::where($this->selectSearch, 'LIKE', '%' . $this->search . '%')
            ->orderBy($this->selectSearch, 'Desc')
            ->paginate('15');

        return view('livewire.inventory', compact('productos'));
    }
}
