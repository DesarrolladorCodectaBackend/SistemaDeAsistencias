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


    public function colaboradores(){
        return $this->belongsTo(Colaboradores::class, 'colaborador_id', 'id');
    }

    public function horarios_presenciales(){
        return $this->belongsTo(Horarios_Presenciales::class, 'horarios_presenciales_id', 'id');
    }

}