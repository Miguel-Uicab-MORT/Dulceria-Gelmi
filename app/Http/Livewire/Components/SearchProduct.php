<?php

namespace App\Http\Livewire\Components;

use App\Models\Producto;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;

class SearchProduct extends Component
{
    public $search;
    public $alert = false;
    public $producto;
    public $qty = 1, $options = [];
    public $type_search = 1;
    public $selectSearch = 'barcode';
    protected $listeners = ['render' => 'render'];


    public function addItem(Producto $producto)
    {
        $this->producto = $producto;

        if ($this->qty == null) {
            $this->qty = 1;
        }elseif ($this->producto->stock < $this->qty) {
            $this->qty = $this->producto->stock;
        }
        $this->options['cost'] = $this->producto->cost;
        $this->options['gain'] = $this->producto->price - $this->producto->cost;
        $this->options['barcode'] = $this->producto->barcode;

        Cart::add([
            'id' => $this->producto->id,
            'name' => $this->producto->description,
            'qty' => $this->qty,
            'price' => $this->producto->price,
            'weight' => 550,
            'options' => $this->options
        ]);

        $this->qty = 1;
        $this->emit('render');
    }

    public function updatedTypeSearch($value)
    {
        if ($value == 1) {
            $this->selectSearch = "barcode";
            $this->search = "";
        } elseif ($value == 2) {
            $this->selectSearch = "description";
            $this->search = "";
        }
    }

    public function updatedSearch($value)
    {
        $this->alert = false;

        if ($this->type_search == 1) {
            $producto = Producto::where('barcode', $value)
                ->where('status', Producto::Activo)
                ->get();
            if ($producto == null) {
                $this->alert = 1;
            } else {
                foreach ($producto as $item) {
                    $this->addItem($item);
                    $this->search = "";
                    $this->search = "";
                }
                $this->emit('render');
            }

        }
    }

    public function alert()
    {
        if ($this->alert == true) {
            $this->alert = false;
        }
    }

    public function render()
    {
        $productos = Producto::where($this->selectSearch, 'LIKE', '%' . $this->search . '%')
            ->where('status', Producto::Activo)
            ->orderBy($this->selectSearch, 'Desc')->get();

        return view('livewire.components.search-product', compact('productos'));
    }
}
