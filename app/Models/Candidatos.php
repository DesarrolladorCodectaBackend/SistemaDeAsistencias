<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidatos extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'direccion',
        'fecha_nacimiento',
        'ciclo_de_estudiante',
        'estado',
        'sede_id',
        'carrera_id',
        'correo',
        'celular',
        'icono',
    ];

    public function sede(){
        return $this->belongsTo(Sede::class, 'sede_id', 'id');
    }

    public function carrera(){
        return $this->belongsTo(Carrera::class, 'carrera_id', 'id');
    }

    public function colaborador(){
        return $this->hasOne(Colaboradores::class, 'candidato_id', 'id');
    }

}
