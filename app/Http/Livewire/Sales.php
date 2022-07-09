<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\Venta;
use Carbon\Carbon;
use Facturapi\Facturapi;
use Livewire\Component;
use Livewire\WithPagination;

class Sales extends Component
{
    use WithPagination;

    public $search, $day;
    public $venta;
    public $type_payment = 1, $selectSearch = "id";
    public $idClient, $ventaSelect;
    public $selectCliente = false;
    public $facturable = Venta::Facturable;

    public function SelectCliente(Venta $venta)
    {
        if ($this->selectCliente == false) {
            $this->selectCliente = true;
            $this->ventaSelect = $venta;
        } else {
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
        $typePerson = $cliente->typePerson;

        $items = [];
        $i = 0;

        foreach ($productos as $producto) {
            $items[$i] = [
                "quantity" => $producto->qty,
                "product" => [
                    "description" => $producto->name,
                    "product_key" => $producto->options->key_product,
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
                "tax_system" => $typePerson,
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

    public function facturaDay()
    {
        $ventas = Venta::whereDate('created_at', $this->day)
            ->where('id', 'LIKE', '%' . $this->search . '%')
            ->where('typePayment', $this->type_payment)
            ->where('facturable', $this->facturable)
            ->orderBy('id', 'Desc')->paginate();

        if ($this->search != null) {
            $ventas = Venta::where('id', $this->search)
                ->orderBy('id', 'Desc')->paginate();
        }

        $cliente = Cliente::find(1);
        $businessname = $cliente->businessname;
        $email = $cliente->email;
        $rfc = $cliente->rfc;
        $cp = $cliente->cp;
        $typePerson = $cliente->typePerson;

        $items = [];
        $i = 0;

        foreach ($ventas as $venta) {
            $productos = json_decode($venta->content);
            foreach ($productos as $producto) {
                $items[$i] = [
                    "quantity" => $producto->qty,
                    "product" => [
                        "description" => $producto->name,
                        "product_key" => $producto->options->key_product,
                        "price" => $producto->price
                    ]
                ];
                $i++;
            }
            $this->venta = Venta::find($venta->id);
            $this->venta->facturado = true;
            $this->venta->save();
        }

        $facturapi = new Facturapi('sk_test_0w48olmaJpVqd3BZXnGmPkWdZY1RWgMAnQjbPzeO5y');

        $invoice = $facturapi->Invoices->create([
            "customer" => [
                "legal_name" => $businessname,
                "email" => $email,
                "tax_id" => $rfc,
                "tax_system" => $typePerson,
                "address" => [
                    "zip" => $cp
                ]
            ],
            "items" => $items,
            "payment_form" => "28" // Tarjeta de crédito
        ]);

        $facturapi->Invoices->send_by_email($invoice->id);

        $this->emit('alert', 'La factura se emitio correctamente y enviada por correo electronico.');
    }

    public function show(Venta $venta)
    {
        return redirect()->route('reports.show', $venta);
    }

    public function printTicket(Venta $venta)
    {
    }

    public function delete(Venta $venta)
    {
        $venta->delete();
        $this->render();
    }

    public function updatedFacturable($value)
    {
        if ($value == 1) {
            $this->facturable = Venta::Facturable;
        } elseif ($value == 2) {
            $this->facturable = Venta::Nofacturable;
        }
    }

    public function updatedTypePayment($value)
    {
        if ($value == 1) {
            $this->type_payment = Venta::Efectivo;
        } elseif ($value == 2) {
            $this->type_payment = Venta::Credito;
        } elseif ($value == 3) {
            $this->type_payment = Venta::Debito;
        }
    }

    public function mount()
    {
        $this->day = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        $clientes = Cliente::pluck('businessname', 'id');

        $ventas = Venta::whereDate('created_at', $this->day)
            ->where('id', 'LIKE', '%' . $this->search . '%')
            ->where('typePayment', $this->type_payment)
            ->where('facturable', $this->facturable)
            ->orderBy('id', 'Desc')->paginate();

        if ($this->search != null) {
            $ventas = Venta::where('id', $this->search)
                ->orderBy('id', 'Desc')->paginate();
        }

        return view('livewire.sales', compact('ventas', 'clientes'));
    }
}
