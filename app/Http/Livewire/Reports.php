<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\Venta;
use Facturapi\Facturapi;
use item;
use Livewire\Component;
use Livewire\WithPagination;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class Reports extends Component
{
    use WithPagination;

    public $search;
    public $venta;
    public $type_search = 1, $selectSearch = "id";
    public $idClient, $ventaSelect;
    public $selectCliente = false;

    public function SelectCliente(Venta $venta)
    {
        if ($this->selectCliente == false) {
            $this->selectCliente = true;
            $this->ventaSelect = $venta;
        }else {
            $this->selectCliente = false;
        }

    }

    public function createFactura()
    {
        $cliente = Cliente::find($this->idClient);
        $productos = json_decode($this->ventaSelect->content);
        $businessname = $cliente->businessname;
        $email = $cliente->email;
        $rfc = $cliente->rfc;
        $cp = $cliente->cp;

        $items = [];
        $i = 0;



        foreach ($productos as $producto) {
            $items[$i] = [
                "quantity" => $producto->qty,
                "product" => [
                    "description" => $producto->name,
                    "product_key" => "60131324",
                    "price" => $producto->price
                ]
            ];
            $i++;
        }

        $facturapi = new Facturapi('sk_test_0w48olmaJpVqd3BZXnGmPkWdZY1RWgMAnQjbPzeO5y');

        $invoice = $facturapi->Invoices->create([
            "customer" => [
                "legal_name" => $businessname,
                "email" => $email,
                "tax_id" => $rfc,
                "tax_system" => "601",
                "address" => [
                    "zip" => $cp
                ]
            ],
            "items" => $items,
            "payment_form" => "28" // Tarjeta de crédito
        ]);

        $facturapi->Invoices->send_by_email($invoice->id);

        $this->selectCliente($this->ventaSelect);
    }

    public function show(Venta $venta)
    {
        return redirect()->route('reports.show', $venta);
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
        $impresora->text("Cajero:" . auth()->user()->name . "\n");
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

    public function delete(Venta $venta)
    {
        $venta->delete();
        $this->render();
    }

    public function updatedTypeSearch($value)
    {
        if ($value == 1) {
            $this->selectSearch = "id";
            $this->search = "";
        } elseif ($value == 2) {
            $this->selectSearch = "created_at";
            $this->search = "";
        }
    }

    public function render()
    {
        $ventas = Venta::where($this->selectSearch, 'LIKE', '%' . $this->search . '%')
            ->orderBy($this->selectSearch, 'Desc')->paginate();

        $clientes = Cliente::pluck('businessname', 'id');

        return view('livewire.reports', compact('ventas', 'clientes'));
    }
}
