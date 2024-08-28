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
            SalonesSeeder::class,
            AreaSeeder::class,
            MaquinasSeeder::class,
            HorariosPresencialesSeeder::class,
            CursoSeeder::class,
            ProgramaSeeder::class,
            SemanaSeeder::class,
            ResponsabilidadSemanalSeeder::class,
            SedeSeeder::class,
            CandidatosSeeder::class,
            HorarioPresencialAsignadoSeeder::class,
            ColaboradoresSeeder::class,
            ColaboradoresPorAreaSeeder::class,
            HorarioDeClasesSeeder::class,
            UsuarioAdministradorSeeder::class,
            UsuarioJefeAreaSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
