<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meses extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'year_id',
        'estado'
    ];

    public function year(){
        return $this->belongsTo(Year::class, 'year_id', 'id');
    }

    public function semanas(){
        return $this->hasMany(Semanas::class, 'mes_id', 'id');
    }

}
