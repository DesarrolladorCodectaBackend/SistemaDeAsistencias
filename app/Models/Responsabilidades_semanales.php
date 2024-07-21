<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsabilidades_semanales extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'porcentaje_peso'
    ];
}
