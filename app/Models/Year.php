<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;

    protected $fillable =[
        'nombre',
        'estado'
    ];

    public function meses(){
        return $this->hasMany(Meses::class, 'year_id', 'id');
    }

}
