<?php

namespace App\Http\Livewire\Components;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Support\Str;
use Livewire\Component;
use Ramsey\Uuid\Generator\RandomGeneratorFactory;

class CreateProduct extends Component
{
    public $create = false;
    public $producto, $categorias, $statusList;
    public $categoria_id, $name, $slug, $description, $cost, $price, $stock, $status, $barcode;
    public $exist_barcode = 2;

    protected $rules = [
        'categoria_id' => 'required',
        'name' => 'required',
        'slug' => 'required|unique:productos,slug',
        'description' => 'required',
        'cost' => 'required',
        'price' => 'required',
        'stock' => 'required',
        'status' => 'required',
        'barcode' => 'required|unique:productos,barcode',
    ];

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function barCodeGenerated()
    {
        $this->reset('barcode');

        $suma = 0;
        for ($i=0; $i < 7; $i++) {
            $digit = random_int(1,9);
            $this->barcode = $this->barcode . $digit;
            if ($i==0 or $i==2 or $i==4 or $i==6) {
                $suma += $digit*3;
            }else {
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
            $this->reset(['categoria_id', 'name', 'slug', 'description', 'cost', 'price', 'stock', 'status', 'barcode']);
        }
    }

    public function store()
    {
        if ($this->exist_barcode == 2) {
            $this->barCodeGenerated();
        }

        $this->validate();

        $producto = new Producto();

        $producto->categoria_id = $this->categoria_id;
        $producto->name = $this->name;
        $producto->slug = $this->slug;
        $producto->description = $this->description;
        $producto->cost = $this->cost;
        $producto->price = $this->price;
        $producto->stock = $this->stock;
        $producto->status = $this->status;
        $producto->barcode = $this->barcode;

        $producto->save();
        $this->reset(['categoria_id', 'name', 'slug', 'description', 'cost', 'price', 'stock', 'status', 'barcode', 'create', 'exist_barcode']);
        $this->emit('render');
    }

    public function mount()
    {
        $this->categorias = Categoria::pluck('name', 'id');
        $this->statusList = ['1' => 'Activo', '2' => 'Inactivo'];
    }

    public function render()
    {
        return view('livewire.components.create-product');
    }
}
