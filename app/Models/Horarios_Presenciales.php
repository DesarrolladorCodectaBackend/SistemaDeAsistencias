<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horarios_Presenciales extends Model
{
    use HasFactory;

    protected $fillable= [
        'hora_inicial',
        'hora_final',
        'dia'
    ];


    /*
    public function disponibilidad_presencial(){
        return $this->hasMany(Disponibilidad_Presencial::class, 'horarios_presenciales_id', 'id');
    }

    public function maquina_reservada(){
        return $this->hasMany(Maquina_reservada::class, 'horario_presencial_id', 'id');
    }
    */
}
