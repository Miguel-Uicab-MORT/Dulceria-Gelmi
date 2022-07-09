<?php

namespace App\Http\Livewire\Components;

use App\Models\Producto;
use Livewire\Component;
use Ramsey\Uuid\Generator\RandomGeneratorFactory;

class CreateProduct extends Component
{
    public $keys_products = [];
    public $create = false;
    public $producto, $statusList;
    public $name, $key_product, $cost, $price, $stock, $status, $barcode;
    public $exist_barcode = 2;

    protected $rules = [
        'name' => 'required',
        'key_product' => 'required',
        'cost' => 'required',
        'price' => 'required',
        'stock' => 'required',
        'status' => 'required',
        'barcode' => 'required|unique:productos,barcode',
    ];

    public function barCodeGenerated()
    {
        $this->reset('barcode');

        $suma = 0;
        for ($i = 0; $i < 7; $i++) {
            $digit = random_int(1, 9);
            $this->barcode = $this->barcode . $digit;
            if ($i == 0 or $i == 2 or $i == 4 or $i == 6) {
                $suma += $digit * 3;
            } else {
                $suma += $digit;
            }
        }
        $nctrl = round($suma, -1);
        if ($nctrl < $suma) {
            $nctrl = $nctrl + 10;
        }
        $nctrl = $nctrl - $suma;

        $this->barcode = $this->barcode . $nctrl;
    }

    public function create()
    {
        if ($this->create == false) {
            $this->create = true;
        } else {
            $this->create = false;
            $this->reset(['name', 'key_product', 'cost', 'price', 'stock', 'status', 'barcode']);
        }
    }

    public function store()
    {
        if ($this->exist_barcode == 2) {
            $this->barCodeGenerated();
        }

        $this->validate();

        $producto = new Producto();

        $producto->name = $this->name;
        $producto->key_product = $this->key_product;
        $producto->cost = $this->cost;
        $producto->price = $this->price;
        $producto->stock = $this->stock;
        $producto->status = $this->status;
        $producto->barcode = $this->barcode;

        $producto->save();
        $this->reset(['name', 'key_product', 'cost', 'price', 'stock', 'status', 'barcode', 'create', 'exist_barcode']);
        $this->emit('render');
        $this->emit('alert', 'El producto se agrego correctamente');
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

    public function render()
    {
        return view('livewire.components.create-product');
    }
}
