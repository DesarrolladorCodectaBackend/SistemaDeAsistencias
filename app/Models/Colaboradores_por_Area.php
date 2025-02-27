<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaboradores_por_Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'colaborador_id',
        'area_id'
    ];

    
    public function colaboradores(){
        return $this->belongsTo(Colaboradores::class, 'colaborador_id', 'id');
    }

    public function area(){
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }

}
