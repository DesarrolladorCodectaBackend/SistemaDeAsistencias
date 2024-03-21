<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario_Virtual_Colaborador extends Model
{
    use HasFactory;

    protected $fillable = [
        'horario_virtual_id',
        'colaborador_id'
    ];


    public function horarios_virtuales(){
        return $this->belongsTo(Horarios_Virtuales::class, 'horario_virtual_id', 'id');
    }

    public function colaboradores(){
        return $this->belongsTo(Colaboradores::class, 'colaborador_id', 'id');
    }

}
