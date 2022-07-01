<?php

namespace App\Http\Livewire\Components;

use App\Models\Producto;
use App\Models\Venta;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class PaymentSale extends Component
{
    public $paymentModal = false;
    public $cambioModal = false;
    public $ticket = 1;
    public $subtotal = 0;
    public $total = 0;
    public $recibido;
    public $cambio = 0;
    public $costo = 0;
    public $ganancia = 0;
    public $producto;
    protected $rules = [
        'recibido' => 'required',
    ];

    public function updateTicket($value)
    {
        $this->ticket = $value;
    }

    public function paymentModal()
    {
        if ($this->paymentModal == false) {
            $this->paymentModal = true;
            $this->subtotal = Cart::subtotal();

        } elseif ($this->paymentModal == true) {
            $this->paymentModal = false;
            $this->subtotal = 0;
        }
    }

    public function cambioModal()
    {
        if ($this->cambioModal == false) {
            $this->cambioModal = true;
        } elseif ($this->cambioModal == true) {
            $this->cambioModal = false;
            $this->paymentModal = false;
            Cart::destroy();
            redirect()->route('pointsale.create');
        }
    }

    public function paymentSale()
    {
        $this->validate();

        foreach (Cart::content() as $item) {
            $this->costo += $item->options->cost * $item->qty;
            $this->ganancia += $item->options->gain * $item->qty;
            $this->total += $item->qty * $item->price;
        }

        $this->cambio = $this->recibido - $this->total;

        $venta = new Venta();

        $venta->costo = $this->costo;
        $venta->total = $this->total;
        $venta->ganancia = $this->ganancia;
        $venta->recibido = $this->recibido;
        $venta->cambio = $this->cambio;
        $venta->content = Cart::content();
        $venta->user_id = auth()->user()->id;

        $venta->save();

        $items = json_decode($venta->content);

        foreach ($items as $item) {
            $this->producto = Producto::find($item->id);
            $this->producto->stock = $this->producto->stock - $item->qty;
            if ($this->producto->stock == 0) {
                $this->producto->status = Producto::Inactivo;
            }
            $this->producto->save();
        }

        if ($this->ticket == 2) {
            $this->printTicket($venta);
        }

        $this->cambioModal();
    }

    public function printTicket(Venta $venta)
    {
        $nombreImpresora = "MINIPRINT";
        $connector = new WindowsPrintConnector($nombreImpresora);
        $logo = EscposImage::load("img/logo-ticket.png");
        $impresora = new Printer($connector);
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->bitImageColumnFormat($logo);
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->setEmphasis(true);
        $impresora->text("Ticket de venta\n");
        $impresora->text("FERRETERIA EL INGENIERO\n");
        $impresora->setEmphasis(false);
        $impresora->text("Col. 20 de noviembre, C. Francisco Imadero Entre Pino Suárez, CP: 24085\n");
        $impresora->text("ruizgarciajoseignacio7@gmail.com\n");
        $impresora->text("Cotizaciones: 9811385479\n");
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

    public function render()
    {
        return view('livewire.components.payment-sale');
    }
}
