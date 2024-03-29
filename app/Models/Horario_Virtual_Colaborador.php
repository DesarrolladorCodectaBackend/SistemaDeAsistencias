<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario_virtual_colaborador extends Model
{
    use HasFactory;

    protected $fillable = [
        'horario_virtual_id',
        'semana_id',
        'area_id'
    ];
}
