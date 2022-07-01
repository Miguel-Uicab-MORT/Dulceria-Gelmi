<?php

namespace App\Http\Livewire;

use App\Models\Venta;
use item;
use Livewire\Component;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class ShowSale extends Component
{
    public $venta;

    public function mount(Venta $venta)
    {
        $this->venta = $venta;
    }

    public function printTicket(Venta $venta)
    {
        $nombreImpresora = "MINIPRINT";
        $connector = new WindowsPrintConnector($nombreImpresora);
        $impresora = new Printer($connector);
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->setEmphasis(true);
        $impresora->text("Ticket de venta\n");
        $impresora->text("FERRETERIA EL INGENIERO\n");
        $impresora->setEmphasis(false);
        $impresora->text("Col. 20 de noviembre, C. Francisco Imadero Entre Pino Suárez, CP: 24085\n");
        $impresora->text("ruizgarciajoseignacio7@gmail.com\n");
        $impresora->text("9811385479\n");
        $impresora->text("-------------------------------\n");
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        $impresora->text("Cajero:" . auth()->user()->name. "\n");
        $impresora->text("Ticket: " . $venta->id . "\n");
        $impresora->text($venta->created_at . "\n");
        $impresora->text("-------------------------------\n");

        $productos = json_decode($venta->content);

        foreach ($productos as $producto) {
            $subtotal = $producto->qty * $producto->price;
            $impresora->setJustification(Printer::JUSTIFY_LEFT);
            $impresora->text(sprintf("%.2fx%s\n", $producto->qty, $producto->name));
            $impresora->setJustification(Printer::JUSTIFY_RIGHT);
            $impresora->text('$' . number_format($subtotal, 2) . "\n");
        }
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->text("-------------------------------\n");
        $impresora->setJustification(Printer::JUSTIFY_RIGHT);
        $impresora->setEmphasis(true);
        $impresora->text("Total: $" . number_format($venta->total, 2) . "\n");
        $impresora->text("Recibido: $" . number_format($venta->recibido, 2) . "\n");
        $impresora->text("Cambio: $" . number_format($venta->cambio, 2) . "\n");
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->setTextSize(1, 1);
        $impresora->text("Gracias por su compra\n");
        $impresora->text("IR CONSTRUCCIONES");
        $impresora->feed(2);
        $impresora->close();
    }

    public function index()
    {
        return redirect()->route('reports.index');
    }

    public function render()
    {
        $items = json_decode($this->venta->content);

        return view('livewire.show-sale', compact('items'));
    }
}
