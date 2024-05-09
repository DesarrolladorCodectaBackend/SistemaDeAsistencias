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


    public function colaborador(){
        return $this->belongsTo(Colaboradores::class, 'colaborador_id', 'id');
    }

    public function horario_presencial(){
        return $this->belongsTo(Horarios_Presenciales::class, 'horarios_presenciales_id', 'id');
    }

}