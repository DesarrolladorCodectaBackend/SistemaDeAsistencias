<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Salones;

class SalonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Salones::create([
            "nombre" => "Salon N°1",
            "descripcion" => "Descripcion N°1"
        ]);
        Salones::create([
            "nombre" => "Salon N°2",
            "descripcion" => "Descripcion N°2"
        ]);
        Salones::create([
            "nombre" => "Salon N°3",
            "descripcion" => "Descripcion N°3"
        ]);
    }
}
