<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Candidatos;
use Exception;
use Illuminate\Http\Request;

class ColaboradorEditController extends Controller
{

    public function edit() {
        return view('inspiniaViews.colaboradores.edit_colaborador');
    }

    public function search(Request $request) {
        $input = $request->get('input');

        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $candidato = Candidatos::where('correo', $input)->where('estado', 0)->first();
        } else if (is_numeric($input)) {
            $candidato = Candidatos::where('dni', $input)->where('estado', 0)->first();
        } else {
            return response()->json(['error' => 'El dato ingresado no es válido.'], 400);
        }

        if (!$candidato) {
            return response()->json(['error' => 'Candidato no encontrado o no registrado.'], 404);
        }

        $colaborador = $candidato->colaborador;

        if (!$colaborador || $colaborador->editable != 1) {
            return response()->json(['error' => 'El colaborador ya no se puede editar.'], 403);
        }


        return response()->json([
            'candidato' => $candidato,
            'colaborador' => $colaborador,
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
