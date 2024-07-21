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
            "especializacion" => "Programación",
            "descripcion" => "Descripción de Programación",
            "color_hex" => "#12aafd",
            "salon_id" => 1,
            "icono" => "programacion.svg"
        ]);
        Area::create([
            "especializacion" => "Análisis",
            "descripcion" => "Descripción de Analisis",
            "color_hex" => "#f0aa12",
            "salon_id" => 2,
            "icono" => "analisis.svg"
        ]);
        Area::create([
            "especializacion" => "Planeación",
            "descripcion" => "Descripción de Planeacion",
            "color_hex" => "#45aacc",
            "salon_id" => 1,
            "icono" => "planeacion.svg"
        ]);
        Area::create([
            "especializacion" => "Diseño",
            "descripcion" => "Descripción de Diseño",
            "color_hex" => "#117766",
            "salon_id" => 2,
            "icono" => "diseño.svg"
        ]);

        Area::create([
            "especializacion" => "Arquitectura",
            "descripcion" => "Descripción de Arquitectura",
            "color_hex" => "#234589",
            "salon_id" => 1,
            "icono" => "arquitectura.svg"
        ]);
        Area::create([
            "especializacion" => "Android",
            "descripcion" => "Descripción de Android",
            "color_hex" => "#00aaff",
            "salon_id" => 3,
            "icono" => "android.svg"
        ]);
        Area::create([
            "especializacion" => "Inteligencia Artificial",
            "descripcion" => "Descripción de IA",
            "color_hex" => "#0000ff",
            "salon_id" => 1,
            "icono" => "ia.svg"
        ]);
        Area::create([
            "especializacion" => "Programación Web",
            "descripcion" => "Descripción de Programación Web",
            "color_hex" => "#165478",
            "salon_id" => 1,
            "icono" => "programacion_web.svg"
        ]);

        Area::create([
            "especializacion" => "Videojuegos",
            "descripcion" => "Descripción de Videojuegos",
            "color_hex" => "#a15c68",
            "salon_id" => 1,
            "icono" => "videojuegos.svg"
        ]);

    }
}
