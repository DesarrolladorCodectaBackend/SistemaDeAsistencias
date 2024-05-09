<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre'
    ];
    
    public function candidato(){
        return $this->hasMany(Candidatos::class, 'institucion_id', 'id');
    }

}
