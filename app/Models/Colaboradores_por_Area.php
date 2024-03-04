<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaboradores_por_Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'colaborador_id',
        'area_id'
    ];

}
