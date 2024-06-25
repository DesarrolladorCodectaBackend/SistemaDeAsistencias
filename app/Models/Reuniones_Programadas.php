<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reuniones_Programadas extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'dia',
        'hora_inicial',
        'hora_final'
    ];


    public function area(){
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }

}
