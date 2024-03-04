<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Copy_of_Maquinas extends Model
{
    use HasFactory;

    protected $fillable = [
        'horario_presencial_id',
        'maquina_id'
    ];
}
