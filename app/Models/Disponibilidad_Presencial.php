<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disponibilidad_Presencial extends Model
{
    use HasFactory;

    protected $fillable = [
        'colaborador_id',
        'horarios_presenciales_id'
    ];


}