<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'porcentaje',
        'area_id',
        'estado'
    ];

    public function area() {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }
}
