<?php

namespace App\Http\Livewire;

use App\Models\Producto;
use App\Models\Venta;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class PointSale extends Component
{
    public $search;
    public $alert = false;
    public $producto;
    public $qty = 1, $options = [];
    public $type_sale = Venta::Facturable;
    protected $listeners = ['render' => 'render'];

    public function addItem(Producto $producto)
    {
        $this->producto = $producto;

        if ($this->qty == null) {
            $this->qty = 1;
        } elseif ($this->producto->stock < $this->qty) {
            $this->qty = $this->producto->stock;
        }
        $this->options['cost'] = $this->producto->cost;
        $this->options['gain'] = $this->producto->price - $this->producto->cost;
        $this->options['key_product'] = $this->producto->key_product;

        Cart::add([
            'id' => $this->producto->id,
            'name' => $this->producto->name,
            'qty' => $this->qty,
            'price' => $this->producto->price,
            'weight' => 550,
            'options' => $this->options
        ]);

        $this->qty = 1;
        $this->render();
    }


    public function updatedSearch($value)
    {
        $this->alert = false;

        $producto = Producto::where('barcode', $value)
            ->where('status', Producto::Activo)
            ->get();
        foreach ($producto as $item) {
            $this->addItem($item);
            $this->search = "";
            $this->qty = 1;
        }
        $this->render();
    }

    public function updatedTypeSale($value)
    {
        if ($value == 1) {
            $this->typeSale = Venta::Facturable;
            $this->emit('SaleFacturable');
        } elseif ($value == 2) {
            $this->typeSale = Venta::Nofacturable;
            $this->emit('SaleNofacturable');
        }
    }

    public function removeItem($rowID)
    {
        Cart::remove($rowID);
        $this->render();
    }

    public function render()
    {
        return view('livewire.point-sale');
    }
}
