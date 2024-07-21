<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Responsabilidades_semanales;

class ResponsabilidadSemanalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Responsabilidades_semanales::create([
            'nombre' => 'Asistencia diaria',
            'porcentaje_peso' => '14'
        ]);
        Responsabilidades_semanales::create([
            'nombre' => 'Reuniones virtuales',
            'porcentaje_peso' => '14'
        ]);
        Responsabilidades_semanales::create([
            'nombre' => 'Aportes de ideas',
            'porcentaje_peso' => '14'
        ]);
        Responsabilidades_semanales::create([
            'nombre' => 'Participación',
            'porcentaje_peso' => '14'
        ]);
        Responsabilidades_semanales::create([
            'nombre' => 'Presentación de trabajos',
            'porcentaje_peso' => '14'
        ]);
        Responsabilidades_semanales::create([
            'nombre' => 'Lecturas',
            'porcentaje_peso' => '14'
        ]);
        Responsabilidades_semanales::create([
            'nombre' => 'Faltas Justificadas',
            'porcentaje_peso' => '14'
        ]);
    }
}
