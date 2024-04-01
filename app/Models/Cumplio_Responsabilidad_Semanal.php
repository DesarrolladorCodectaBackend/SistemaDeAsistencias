<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cumplio_Responsabilidad_Semanal extends Model
{
    use HasFactory;

    protected $fillable = [
        'colaborador_area_id',
        'responsabilidad_id',
        'semana_id',
        'cumplio'
    ];
    
}
