<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    const Facturable = 1;
    const Nofacturable = 2;

    const Efectivo = 1;
    const Credito = 2;
    const Debito = 3;

    protected $guarded = [
        'id',
        'creat_at',
        'update_at',
    ];

    /**
     * Relación uno a muchos inversa
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
