<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTransacciones extends Model
{
    use HasFactory;

    protected $table = 'tipo_transacciones';

    protected $fillable = [
        'descripcion',
        'es_ingreso'
    ];
}
