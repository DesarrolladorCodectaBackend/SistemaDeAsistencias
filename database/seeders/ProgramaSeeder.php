<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Programas;

class ProgramaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Programas::create([
            "nombre" => "Programa1",
            "descripcion" => "Descripcion del Programa 1",
            "icono" => "default.png"
        ]);
        Programas::create([
            "nombre" => "Programa2",
            "descripcion" => "Descripcion del Programa 2",
            "icono" => "default.png"
        ]);
        
    }
}
