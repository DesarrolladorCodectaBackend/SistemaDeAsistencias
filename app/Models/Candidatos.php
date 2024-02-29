<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidatos extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'direccion',
        'fecha_nacimiento',
        'ciclo_de_estudiante',
        'estado',
        'institucion_id',
        'carrera_id'
    ];

}
