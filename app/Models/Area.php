<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'especializacion',
        'descripcion',
        'color_hex',
        'estado',
        'salon_id',
        'icono',
    ];


    public function colaborador_por_area(){
        return $this->hasMany(Colaboradores_por_Area::class, 'area_id', 'id');
    }

    public function salon(){
        return $this->belongsTo(Salones::class,'salon_id','id');
    }

    public function usuario_colaborador() {
        return $this->hasMany(UsuarioColaborador::class, 'area_id', 'id');
    }

}
