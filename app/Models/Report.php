<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    const Caja1 = 1;
    const Caja2 = 2;

    protected $guarded = [
        'id',
        'creat_at',
        'update_at',
    ];
}
