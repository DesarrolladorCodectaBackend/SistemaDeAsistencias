<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioColaborador extends Model
{
    use HasFactory;

    protected $table = 'usuarios_colaboradores';

    protected $fillable = [
        'user_id',
        'area_id'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function area(){
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }
}
