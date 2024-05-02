<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Colaboradores;

class ColaboradoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Colaboradores::create([
            "candidato_id" => 1,
            "estado" => true 
        ]);

        Colaboradores::create([
            "candidato_id" => 2,
            "estado" => true 
        ]);
    }
}
