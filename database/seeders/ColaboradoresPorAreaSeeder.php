<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Colaboradores_por_Area;

class ColaboradoresPorAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Colaboradores_por_Area::create([
            "colaborador_id" => 1,
            "area_id" => 2,
            "semana_inicio_id" => NULL
        ]);

        Colaboradores_por_Area::create([
            "colaborador_id" => 2,
            "area_id" => 1,
            "semana_inicio_id" => NULL
        ]);
    }
}
