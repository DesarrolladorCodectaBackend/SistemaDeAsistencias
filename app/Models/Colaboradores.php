<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaboradores extends Model
{
    use HasFactory;

    protected $fillable = [
        'estado',
        'candidato_id'
    ];


    public function candidatos(){
        return $this->belongsTo(Candidatos::class, 'candidato_id', 'id');
    }

    public function colaboradores_por_area(){
        return $this->hasMany(Colaboradores_por_Area::class, 'colaborador_id', 'id');
    }    

    public function disponibilidad_presencial(){
        return $this->hasMany(Disponibilidad_Presencial::class, 'colaborador_id', 'id');
    }
    
    public function horario_de_clases(){
        return $this->hasMany(Horario_de_Clases::class, 'colaborador_id', 'id');
    }

    public function horario_virtual_colaborador(){
        return $this->hasMany(Horario_Virtual_Colaborador::class, 'colaborador_id', 'id');
    }

}
