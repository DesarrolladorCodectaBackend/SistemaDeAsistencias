<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquinas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'estado',
        'detalles_tecnicos',
        'num_identificador',
        'salon_id'
    ];


    public function salon(){
        return $this->belongsTo(Salones::class, 'salon_id', 'id');
    }

    public function copy_of_maquinas(){
        return $this->hasMany(Copy_of_Maquinas::class, 'maquina_id', 'id');
    }

}
