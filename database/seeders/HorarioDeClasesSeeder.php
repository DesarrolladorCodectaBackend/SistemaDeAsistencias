<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Horario_de_Clases;

class HorarioDeClasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Horario_de_Clases::create([
            "colaborador_id" => 1,
            "hora_inicial" => "07:00",
            "hora_final" => "19:00",
            "dia" => "Lunes"
        ]);
        Horario_de_Clases::create([
            "colaborador_id" => 2,
            "hora_inicial" => "07:00",
            "hora_final" => "12:00",
            "dia" => "Miercoles"
        ]);
        Horario_de_Clases::create([
            "colaborador_id" => 2,
            "hora_inicial" => "07:00",
            "hora_final" => "17:00",
            "dia" => "Viernes"
        ]);
    }
}
