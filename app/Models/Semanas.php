<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semanas extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_lunes'
    ];


    public function horario_virtual_colaborador(){
        return $this->hasMany(Horario_virtual_colaborador::class, 'semana_id', 'id');
    }


}
