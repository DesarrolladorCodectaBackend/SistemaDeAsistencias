<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Colaboradores;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CarreraSeeder::class,
            InstitucionSeeder::class,
            AreaSeeder::class,
            CursoSeeder::class,
            ProgramaSeeder::class,
            SemanaSeeder::class,
                //YearSeeder::class,
            SalonesSeeder::class,
                //MesSeeder::class,
            ResponsabilidadSemanalSeeder::class,
            MaquinasSeeder::class,
            CandidatosSeeder::class,
            ColaboradoresSeeder::class,
            ColaboradoresPorAreaSeeder::class,
            HorarioDeClasesSeeder::class

        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
