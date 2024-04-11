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
        'icono'
    ];


    public function colaboradores_por_area(){
        return $this->hasMany(Colaboradores_por_Area::class, 'area_id', 'id');
    }

}
