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
        'icono',
    ];


    public function colaborador_por_area(){
        return $this->hasMany(Colaboradores_por_Area::class, 'area_id', 'id');
    }

}
