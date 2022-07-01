<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    const Faturable = 1;
    const Nofaturable = 2;

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
