<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computadora_colaborador extends Model
{
    use HasFactory;

    protected $fillable = [
        'colaborador_id',
        'procesador',
        'tarjeta_grafica',
        'ram',
        'almacenamiento',
        'es_laptop',
        'codigo_serie'
    ];

    public function colaboradores(){
        return $this->belongsTo(Colaboradores::class, 'colaborador_id', 'id');
    }

    public function programas_instalados(){
        return $this->hasMany(Programas_instalados::class, 'computadora_id', 'id');
    }

}
