<?php

namespace App\Http\Livewire\Components;

use App\Models\Producto;
use App\Models\Venta;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class PaymentSale extends Component
{
    protected $listeners = ['render' => 'render', 'SaleFacturable', 'SaleNofacturable'];

    public $paymentModal = false;
    public $cambioModal = false;

    public $total = 0;
    public $efectivo = 0;
    public $debito = 0;
    public $credito = 0;
    public $recibido = 0;
    public $cambio = 0;

    public $costo = 0;
    public $ganancia = 0;
    public $typePayment, $typeSale = Venta::Facturable;
    public $producto;

    protected $rules = [
        'recibido' => 'required',
    ];

    public function SaleFacturable()
    {
        $this->typeSale = Venta::Facturable;
    }

    public function SaleNofacturable()
    {
        $this->typeSale = Venta::Nofacturable;
    }

    public function updatedCredito()
    {
        if ($this->credito != null) {
            if ($this->credito == null) {
                $this->credito = 0;
            }
            if ($this->debito == null) {
                $this->debito = 0;
            }
            if ($this->efectivo == null) {
                $this->efectivo = 0;
            }
            $this->recibido = $this->credito + $this->debito + $this->efectivo;
        }
    }

    public function updatedDebito()
    {
        if ($this->debito != null) {
            if ($this->credito == null) {
                $this->credito = 0;
            }
            if ($this->debito == null) {
                $this->debito = 0;
            }
            if ($this->efectivo == null) {
                $this->efectivo = 0;
            }
            $this->recibido = $this->credito + $this->debito + $this->efectivo;
        }
    }

    public function updatedEfectivo()
    {
        if ($this->efectivo != null) {
            if ($this->credito == null) {
                $this->credito = 0;
            }
            if ($this->debito == null) {
                $this->debito = 0;
            }
            if ($this->efectivo == null) {
                $this->efectivo = 0;
            }
            $this->recibido = $this->credito + $this->debito + $this->efectivo;
        }
    }

    public function paymentModal()
    {
        if ($this->paymentModal == false) {
            $this->reset('total');
            $this->paymentModal = true;
            foreach (Cart::content() as $item) {
                $this->total += $item->qty * $item->price;
            }
        } elseif ($this->paymentModal == true) {
            $this->paymentModal = false;
            $this->total = 0;
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
        $this->reset('cambio', 'costo', 'ganancia');

        $this->validate();

        foreach (Cart::content() as $item) {
            $this->costo += $item->options->cost * $item->qty;
            $this->ganancia += $item->options->gain * $item->qty;
        }

        $this->cambio = $this->recibido - $this->total;

        if ($this->efectivo > $this->debito and $this->efectivo > $this->credito) {
            $this->typePayment = Venta::Efectivo;
        }elseif ($this->credito > $this->debito and $this->credito > $this->efectivo) {
            $this->typePayment = Venta::Credito;
        }elseif ($this->debito > $this->credito and $this->debito > $this->efectivo) {
            $this->typePayment = Venta::Debito;
        }

        if ($this->credito == null) {
            $this->credito = 0;
        }
        if ($this->debito == null) {
            $this->debito = 0;
        }
        if ($this->efectivo == null) {
            $this->efectivo = 0;
        }

        $venta = new Venta();

        $venta->costo = $this->costo;
        $venta->total = $this->total;
        $venta->ganancia = $this->ganancia;
        $venta->efectivo = $this->efectivo;
        $venta->credito = $this->credito;
        $venta->debito = $this->debito;
        $venta->recibido = $this->recibido;
        $venta->cambio = $this->cambio;
        $venta->content = Cart::content();
        $venta->typePayment = $this->typePayment;
        $venta->facturable = $this->typeSale;
        $venta->user_id = auth()->user()->id;

        $venta->save();

        $items = json_decode($venta->content);

        foreach ($items as $item) {
            $this->producto = Producto::find($item->id);
            $this->producto->stock = $this->producto->stock - $item->qty;
            if ($this->producto->stock == 0) {
                $this->producto->status = Producto::Inactivo;
            }

            $this->paymentModal = false;
            $this->producto->save();
        }


        $this->cambioModal();
    }

    public function printTicket(Venta $venta)
    {
    }

    public function render()
    {
        return view('livewire.components.payment-sale');
    }
}
