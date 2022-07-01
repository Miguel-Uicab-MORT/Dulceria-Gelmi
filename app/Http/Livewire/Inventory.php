<?php

namespace App\Http\Livewire;

use App\Exports\BarcodeExport;
use App\Models\Categoria;
use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class Inventory extends Component
{
    use WithPagination;

    public $search;
    public $producto, $categorias, $statusList, $barcode;
    public $edit = false;
    public $type_search = 1;
    public $selectSearch = 'id';

    protected $listeners = ['render' => 'render'];

    protected $rules = [
        'producto.barcode' => 'required',
        'producto.name' => 'required',
        'producto.description' => 'required',
        'producto.slug' => 'required',
        'producto.stock' => 'required',
        'producto.cost' => 'required',
        'producto.price' => 'required',
        'producto.status' => 'required',
        'producto.categoria_id' => 'required'
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
        }elseif ($value == 4) {
            $this->selectSearch = "description";
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
    }

    public function delete(Producto $producto)
    {
        $this->producto = $producto;
        $this->producto->delete();
        $this->render();
    }

    public function mount()
    {
        $this->categorias = Categoria::pluck('name', 'id');
        $this->statusList = ['1' => 'Activo', '2' => 'Inactivo'];
    }

    public function printBarcode(Producto $producto)
    {
        $nombreImpresora = "MINIPRINT";
        $connector = new WindowsPrintConnector($nombreImpresora);
        $impresora = new Printer($connector);
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->text("-------------------------------\n");
        if (strlen($producto->barcode) == 8) {
            $impresora->text($producto->name . "\n");
            $impresora->barcode($producto->barcode, Printer::BARCODE_JAN8);
        } elseif (strlen($producto->barcode) == 13) {
            $impresora->text($producto->name . "\n");
            $impresora->barcode($producto->barcode, Printer::BARCODE_JAN13);
        } elseif (strlen($producto->barcode) == 12) {
            $impresora->text($producto->name . "\n");
            $impresora->barcode($producto->barcode, Printer::BARCODE_UPCA);
        }
        $impresora->text("-------------------------------\n");
        $impresora->feed(3);
        $impresora->close();
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
