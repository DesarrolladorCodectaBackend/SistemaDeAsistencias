<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Meses;

class MesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Meses::create([
            "nombre" => "Enero",
            "year_id" => 1
        ]);
        Meses::create([
            "nombre" => "Febrero",
            "year_id" => 1
        ]);
        Meses::create([
            "nombre" => "Marzo",
            "year_id" => 1
        ]);
        Meses::create([
            "nombre" => "Abril",
            "year_id" => 1
        ]);
        Meses::create([
            "nombre" => "Mayo",
            "year_id" => 1
        ]);
        Meses::create([
            "nombre" => "Junio",
            "year_id" => 1
        ]);
        Meses::create([
            "nombre" => "Julio",
            "year_id" => 1
        ]);
        Meses::create([
            "nombre" => "Agosto",
            "year_id" => 1
        ]);
        Meses::create([
            "nombre" => "Septiembre",
            "year_id" => 1
        ]);
        Meses::create([
            "nombre" => "Octubre",
            "year_id" => 1
        ]);
        Meses::create([
            "nombre" => "Noviembre",
            "year_id" => 1
        ]);
        Meses::create([
            "nombre" => "Diciembre",
            "year_id" => 1
        ]);
    }
}
