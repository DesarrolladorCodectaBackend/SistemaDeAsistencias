<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquinas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'estado',
        'detalles_tecnicos',
        'num_identificador',
        'salon_id'
    ];
}
