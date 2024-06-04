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


        Semanas::create([
            "fecha_lunes" => "2024-06-03"
        ]);
        Semanas::create([
            "fecha_lunes" => "2024-06-10"
        ]);
        Semanas::create([
            "fecha_lunes" => "2024-06-17"
        ]);
        Semanas::create([
            "fecha_lunes" => "2024-06-24"
        ]);


        Semanas::create([
            "fecha_lunes" => "2024-07-01"
        ]);
        Semanas::create([
            "fecha_lunes" => "2024-07-08"
        ]);
        Semanas::create([
            "fecha_lunes" => "2024-07-15"
        ]);
        Semanas::create([
            "fecha_lunes" => "2024-07-22"
        ]);
        Semanas::create([
            "fecha_lunes" => "2024-07-29"
        ]);
    }
}
