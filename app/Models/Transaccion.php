<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    use HasFactory;

    protected $table = 'transacciones';

    protected $fillable = [
        'semana_id',
        'nro_pago',
        'nombres',
        'dni',
        'descripcion',
        'observaciones',
        'monto',
        'tipo_transaccion_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($registro) {
            $ultimoPago = self::max('nro_pago');
            $nro_pago = $ultimoPago ? $ultimoPago + 1 : 1;
            $numeroDeDigitos = strlen($nro_pago);
            if ($numeroDeDigitos > 4) {
                $registro->nro_pago = $nro_pago;
            } else {
                $registro->nro_pago = str_pad($nro_pago, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
