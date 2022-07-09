<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\Report;
use App\Models\Venta;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Reports extends Component
{
    use WithPagination;

    public $create = false;

    public $tEfectivo = 0, $c_Efectivo = 0, $dEfectivo = 0;

    public $tDebito = 0, $c_Debito = 0, $dDebito = 0;

    public $tCredito = 0, $c_Credito = 0, $dCredito = 0;

    public $tTotal, $c_Total = 0, $dTotal;

    public $r_Efectivo = 0, $r_Debito = 0, $rTotal = 0, $fondo = 0;

    public $latestCaja = 0;

    public $search;
    public $caja = Report::Caja1;

    public function create()
    {
        if ($this->create == false) {
            $this->create = true;
        } else {
            $this->create = false;
        }
    }

    public function updatedCaja($value)
    {
        if ($value == 1) {
            $this->caja = Report::Caja1;
        }elseif ($value == 2) {
            $this->caja = Report::Caja2;
        }
    }

    public function updatedCEfectivo()
    {
        if ($this->c_Efectivo != null) {
            $this->dEfectivo = $this->c_Efectivo - $this->tEfectivo;
            $this->c_Total = $this->c_Debito + $this->c_Efectivo;

            $this->r_Efectivo = $this->c_Efectivo;
            $this->rTotal = $this->r_Efectivo + $this->r_Debito;
            $this->fondo = $this->c_Total - $this->rTotal + $this->latestCaja;
        }
    }

    public function updatedCDebito()
    {
        if ($this->c_Debito != null) {
            $this->dDebito = $this->c_Debito - $this->tDebito;
            $this->c_Total = $this->c_Debito + $this->c_Efectivo;

            $this->r_Debito = $this->c_Debito;
            $this->rTotal = $this->r_Efectivo + $this->r_Debito;
            $this->fondo = $this->c_Total - $this->rTotal + $this->latestCaja;
        }
    }

    public function updatedREfectivo()
    {
        if ($this->r_Efectivo != null) {
            $this->rTotal = $this->r_Efectivo + $this->r_Debito;
            $this->fondo = $this->c_Total - $this->rTotal + $this->latestCaja;
        }
    }

    public function updatedRDebito()
    {
        if ($this->r_Debito != null) {
            $this->rTotal = $this->r_Efectivo + $this->r_Debito;
            $this->fondo = $this->c_Total - $this->rTotal + $this->latestCaja;
        }
    }

    public function store()
    {
        $corte = new Report();

        $corte->efectivo = $this->c_Efectivo;
        $corte->Debito = $this->c_Debito;
        $corte->total = $this->c_Total;

        $corte->rEfectivo = $this->r_Efectivo;
        $corte->rDebito = $this->r_Debito;
        $corte->rTotal = $this->rTotal;

        $corte->dEfectivo = $this->dEfectivo;
        $corte->dDebito = $this->dDebito;
        $corte->dTotal = $this->dTotal;

        $corte->fondo = $this->fondo;

        $corte->user_id = auth()->user()->id;

        $corte->save();
        $this->create = false;
    }

    public function render()
    {
        $today = Carbon::now()->format('Y-m-d');

        $cajero = auth()->user()->id;

        $report = Report::latest('created_at')->first();

        if ($report != null) {
            $this->latestCaja = $report->fondo;
        }


        $this->tEfectivo = Venta::whereDate('created_at', $today)
            ->where('user_id', $cajero)
            ->sum('efectivo');
        $this->tDebito = Venta::whereDate('created_at', $today)
            ->where('user_id', $cajero)
            ->sum('debito');


        $this->tTotal = $this->tDebito + $this->tEfectivo;
        $this->dTotal = $this->dDebito + $this->dEfectivo;

        return view('livewire.reports', compact('cajero', 'report'));
    }
}
