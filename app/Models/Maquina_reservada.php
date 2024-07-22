<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquina_reservada extends Model
{
    use HasFactory;

    protected $fillable = [
        'horario_presencial_id',
        'maquina_id'
    ];

    public function maquina(){
        return $this->belongsTo(Maquinas::class, 'maquina_id', 'id');
    }   

    public function horario_presenciale(){
        return $this->belongsTo(Horarios_Presenciales::class, 'horario_presencial_id', 'id');
    }
}
