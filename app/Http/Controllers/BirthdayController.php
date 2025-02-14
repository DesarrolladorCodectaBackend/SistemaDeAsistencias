<?php

namespace App\Http\Controllers;

use App\Models\Colaboradores;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BirthdayController extends Controller
{
    public function index()
    {
        // Obtener los cumpleaños desde la base de datos con la relación a candidatos
        $birthdays = Colaboradores::with('candidato')->get();

        // Formatear los datos para FullCalendar
        $events = [];
        foreach ($birthdays as $colaborador) {
            $fechaNacimiento = Carbon::parse($colaborador->candidato->fecha_nacimiento);
            $fechaCumple = $fechaNacimiento->format('m-d'); // Solo día y mes

            // Crear un evento para cada cumpleaños (se repite cada año)
            $events[] = [
                'title' => '🎉 ' . $colaborador->candidato->nombre . ' ' . $colaborador->candidato->apellido,
                'start' => Carbon::now()->year . '-' . $fechaCumple, // Año actual + día y mes
                'allDay' => true,
                'description' => 'Cumpleaños de ' . $colaborador->candidato->nombre . ' ' . $colaborador->candidato->apellido,
            ];
        }

        // Pasar los datos a la vista
        return view('inspiniaViews.birthdays.index', compact('events'));
    }
}
