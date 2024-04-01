<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario_Presencial_Asignado extends Model
{
    use HasFactory;

    protected $fillable = [
        'horario_presencial_id',
        'area_id'
    ];

}
