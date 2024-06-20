<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Horario_Presencial_Asignado;

class HorarioPresencialAsignadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //LUNES
        Horario_Presencial_Asignado::create([
            'horario_presencial_id' => 1,
            'area_id' => 1
        ]);
        Horario_Presencial_Asignado::create([
            'horario_presencial_id' => 2,
            'area_id' => 2
        ]);

        //MARTES
        Horario_Presencial_Asignado::create([
            'horario_presencial_id' => 3,
            'area_id' => 3
        ]);
        Horario_Presencial_Asignado::create([
            'horario_presencial_id' => 4,
            'area_id' => 4
        ]);
    }
}
