<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Candidatos;
use App\Models\Carrera;
use App\Models\Colaboradores;
use App\Models\Especialista;
use App\Models\Sede;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ColaboradorEditController extends Controller
{

    public function edit() {
        return view('inspiniaViews.colaboradores.edit_colaborador');
    }

    public function search(Request $request) {
        try {
            $sedes = Sede::get();
            $carreras = Carrera::get();
            $especialistas = Especialista::get();

            $input = $request->get('input');
            $colabData = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'correo' : (is_numeric($input) ? 'dni' : null);

            if (!$colabData) {
                return response()->json(['error' => 'El dato ingresado no es válido.'], 400);
            }

            $candidato = Candidatos::with(['sede', 'carrera', 'colaborador.especialista'])
                ->where($colabData, $input)
                ->where('estado', 0)
                ->first();

            if (!$candidato) {
                return response()->json(['error' => 'Colaborador no registrado.'], 404);
            }

            $colaborador = $candidato->colaborador;

            if (!$colaborador || $colaborador->editable != 1) {
                return response()->json([
                    'error' => 'Este registro ya no se puede editar. Consulte con el área de recursos humanos para volver a editar sus datos.'
                ], 403);
            }

            return response()->json([
                'candidato' => $candidato,
                'colaborador' => $colaborador,
                'sede' => $candidato->sede->nombre,
                'carrera' => $candidato->carrera->nombre,
                'sedes' => $sedes,
                'carreras' => $carreras,
                'especialistas' => $especialistas,
                'especialista' => $colaborador->especialista ? $colaborador->especialista->nombres : null
            ]);
        } catch(Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al buscar el colaborador.'], 500);
        }
    }


    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $candidato = Candidatos::findOrFail($id);

            $errors = [];

            if(!isset($request->nombre)) {
                $errors['nombre'] = 'Campo obligatorio';
            }

            if(!isset($request->apellido)) {
                $errors['apellido'] = 'Campo obligatorio';
            }

            if (isset($request->dni) && strlen($request->dni) !== 8) {
                $errors['dni'] = 'Debe contener 8 dígitos';
            } else if (isset($request->dni)) {
                $candidatos = Candidatos::where('dni', $request->dni)->get();
                foreach ($candidatos as $cand) {
                    if ($cand->id != $id) {
                        $errors['dni'] = 'DNI en uso';
                        break;
                    }
                }
            }

            if(isset($request->correo)){
                $candidatos = Candidatos::where('correo', $request->correo)->get();
                foreach($candidatos as $cand) {
                    if ($cand->id != $id) {
                        $errors['correo'] = 'Correo en uso';
                        break;
                    }
                }
            }

            if(isset($request->celular) && strlen($request->celular) !== 9) {
                $errors['celular'] = 'Debe contener 9 dígitos';
            }else if(isset($request->celular)){
                $candidatos = Candidatos::where('celular', $request->celular)->get();
                foreach($candidatos as $cand) {
                    if ($cand->id != $id) {
                        $errors['celular'] = 'Celular en uso';
                        break;
                    }
                }
            }

            if(!empty($errors)) {
                return response()->json([
                    'errors' => $errors
                ], 422);
            }

            $candidato->update($request->only(['nombre', 'apellido','dni', 'correo', 'celular', 'fecha_nacimiento', 'direccion', 'sede_id', 'ciclo_de_estudiante', 'carrera_id']));

            $colaborador = $candidato->colaborador;
            if ($colaborador) {
                $colaborador->update(['editable' => 0]);
                $colaborador->update($request->only('especialista_id'));
            }

            DB::commit();
            return response()->json(['message' => 'Datos actualizados correctamente']);

        } catch (Exception $e) {

            DB::rollBack();
            return response()->json(['error' => 'Ocurrió un error al actualizar el colaborador.'], 500);

        }
    }

}
