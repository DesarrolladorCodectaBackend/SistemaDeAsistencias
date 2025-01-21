<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Candidatos;
use App\Models\Carrera;
use App\Models\Sede;
use Exception;
use Illuminate\Http\Request;

class ColaboradorEditController extends Controller
{

    public function edit() {
        return view('inspiniaViews.colaboradores.edit_colaborador');
    }

    public function search(Request $request) {
        $sedes = Sede::get();
        $carreras = Carrera::get();
        $input = $request->get('input');
        $colabData = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'correo' : (is_numeric($input) ? 'dni' : null);


        if ($colabData) {
            $candidato = Candidatos::with(['sede', 'carrera'])
            ->where($colabData, $input)
            ->where('estado', 0)
            ->first();
        }else {
            return response()->json(['error' => 'El dato ingresado no es válido.'], 400);
        }

        if (!$candidato) {
            return response()->json(['error' => 'Candidato no registrado.'], 404);
        }

        $colaborador = $candidato->colaborador;

        if (!$colaborador || $colaborador->editable != 1) {
            return response()->json(['error' => 'El colaborador ya no se puede editar.'], 403);
        }


        return response()->json([
            'candidato' => $candidato,
            'colaborador' => $colaborador,
            'sede' => $candidato->sede->nombre,
            'carrera' => $candidato->carrera->nombre,
            'sedes' => $sedes,
            'carreras' => $carreras
        ]);
    }


    public function update(Request $request, $id)
    {
        try {
            $candidato = Candidatos::findOrFail($id);

            $candidato->update($request->only(['nombre', 'apellido','dni', 'correo', 'celular', 'fecha_nacimiento', 'direccion', 'sede_id', 'ciclo_de_estudiante', 'carrera_id']));

            $candidato->colaborador->update(['editable' => 0]);

            return response()->json(['message' => 'Datos actualizados correctamente']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al actualizar el colaborador.'], 500);
        }
    }

}
