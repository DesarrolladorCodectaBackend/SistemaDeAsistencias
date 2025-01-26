<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaboradores extends Model
{
    use HasFactory;

    protected $fillable = [
        'estado',
        'candidato_id',
        'editable',
        'especialista_id',
        'pasaje',
        'comida'
    ];


    public function candidato(){
        return $this->belongsTo(Candidatos::class, 'candidato_id', 'id');
    }

    public function colaborador_por_area(){
        return $this->hasMany(Colaboradores_por_Area::class, 'colaborador_id', 'id');
    }

    public function horario_de_clases(){
        return $this->hasMany(Horario_de_Clases::class, 'colaborador_id', 'id');
    }

    public function horario_virtual_colaborador(){
        return $this->hasMany(Horario_Virtual_Colaborador::class, 'colaborador_id', 'id');
    }

    public function especialista() {
        return $this->belongsTo(Especialista::class, 'especialista_id', 'id');
    }

    public function usuario_colaborador() {
        return $this->hasMany(UsuarioColaborador::class, 'colaborador_id', 'id');
    }
}
