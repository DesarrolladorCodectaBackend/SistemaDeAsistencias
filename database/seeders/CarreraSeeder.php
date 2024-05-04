<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Carrera;

class CarreraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Carrera::create([
            'nombre' => 'Ingeniería de Software con IA'
        ]);
        Carrera::create([
            'nombre' => 'Ingeniería de Ciberseguridad'
        ]);
        Carrera::create([
            'nombre' => 'Ingeniería de Sistemas'
        ]);
    }
}
