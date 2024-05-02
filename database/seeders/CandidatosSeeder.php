<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Candidatos;

class CandidatosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Candidatos::create([
            "nombre" => "Ejemplo",
            "apellido" => "001",
            "dni" => "88888888",
            "direccion" => "direccion ejemplo #001",
            "fecha_nacimiento" => "2000-12-12",
            "ciclo_de_estudiante" => 5,
            "estado" => false,
            "institucion_id" => 1,
            "carrera_id" => 2,
            "correo" => "correoejemplo001@gmail.com",
            "celular" => "888888888",
            "icono" => "default.png",
        ]);

        Candidatos::create([
            "nombre" => "Ejemplo",
            "apellido" => "002",
            "dni" => "99999999",
            "direccion" => "direccion ejemplo #002",
            "fecha_nacimiento" => "2000-12-12",
            "ciclo_de_estudiante" => 6,
            "estado" => false,
            "institucion_id" => 2,
            "carrera_id" => 3,
            "correo" => "correoejemplo002@gmail.com",
            "celular" => "999999999",
            "icono" => "default.png",
        ]);
    }
}
