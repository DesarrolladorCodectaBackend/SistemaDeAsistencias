<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Semanas;
class SemanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Semanas::create([
            "fecha_lunes" => "2024-05-06"
        ]);
        Semanas::create([
            "fecha_lunes" => "2024-05-13"
        ]);
        Semanas::create([
            "fecha_lunes" => "2024-05-20"
        ]);
        Semanas::create([
            "fecha_lunes" => "2024-05-27"
        ]);
    }
}
