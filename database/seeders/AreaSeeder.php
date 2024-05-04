<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create([
            "especializacion" => "Analisis",
            "descripcion" => "Descripción de Analisis",
            "color_hex" => "#f0aa12",
            "icono" => "default.png"
        ]);
        Area::create([
            "especializacion" => "Programación",
            "descripcion" => "Descripción de Programación",
            "color_hex" => "#12aafd",
            "icono" => "default.png"
        ]);
        Area::create([
            "especializacion" => "Videojuegos",
            "descripcion" => "Descripción de Videojuegos",
            "color_hex" => "#00aaff",
            "icono" => "default.png"
        ]);
        Area::create([
            "especializacion" => "IA",
            "descripcion" => "Descripción de IA",
            "color_hex" => "#0000ff",
            "icono" => "default.png"
        ]);
    }
}
