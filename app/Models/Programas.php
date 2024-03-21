<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'memoria_grafica',
        'ram'
    ];

    public function programas_instalados(){
        return $this->hasMany(Programas_instalados::class, 'programa_id', 'id');
    }

}
