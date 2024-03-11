<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horarios_Presenciales extends Model
{
    use HasFactory;

    protected $fillable= [
        'horario_inicial',
        'horario_final',
        'dia'
    ];


    public function disponibilidad_presencial(){
        return $this->hasMany(Disponibilidad_Presencial::class, 'horarios_presenciales_id', 'id');
    }

    public function copy_of_maquinas(){
        return $this->hasMany(Copy_of_Maquinas::class, 'horario_presencial_id', 'id');
    }
}
