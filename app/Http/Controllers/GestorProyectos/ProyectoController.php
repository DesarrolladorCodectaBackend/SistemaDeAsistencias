<?php

namespace App\Http\Controllers\GestorProyectos;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Proyecto;
use App\Models\UsuarioJefeArea;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProyectoController extends Controller
{
    public function index(){
        // traer al objeto jefe area
        $areaPerteneciente = $this->verifyUserJefeArea();

        // traer todos los proyectos del area
        $proyectos = Proyecto::where('area_id', $areaPerteneciente->id)->get();

        return view('inspiniaViews.proyecto.rol-jefe-area.index', [
            'proyectos' => $proyectos
        ]);
    }

    public function store(Request $request) {
        try {
            // traer el objeto area
            $areaPerteneciente = $this->verifyUserJefeArea();

            // store del proyecto con dicha area
            DB::beginTransaction();
            Proyecto::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'porcentaje' => $request->porcentaje,
                'area_id' => $areaPerteneciente->id,
                // estado en default => 1
            ]);

            DB::commit();
            return redirect()->route('proyectos.index')->with('success', 'Proyecto creado correctamente');

        } catch (Exception $e) {

            DB::rollBack();
            return $e;
            return redirect()->route('proyectos.index')->with('error', 'Ocurrió un error, inténtelo más tarde o contacte con el equipo de soporte');

        }
    }

    public function changeState($proyecto_id) {
        try {

            $proyecto = Proyecto::findOrFail($proyecto_id);

            // si el proyecto esta terminado, no cambiar de estado
            if($proyecto->estado == 2 || $proyecto->porcentaje == 100.00) {
                return redirect()->route('proyectos.index')->with('warning', 'Proyecto terminado. No se puede cambiar de estado.');
            }

            DB::beginTransaction();
            if($proyecto->estado == 1) {
                $message = 'Proyecto desactivado';
                $proyecto->update([
                    'estado' => 0
                ]);
            } else if($proyecto->estado == 0) {
                $message = 'Proyecto activado';
                $proyecto->update([
                    'estado' => 1
                ]);
            }

            DB::commit();
            return redirect()->route('proyectos.index')->with('success',$message);

        } catch (Exception $e) {

            DB::rollBack();
            // return $e;
            return redirect()->route('proyectos.index')->with('error', 'Ocurrió un error, inténtelo más tarde o contacte con el equipo de soporte');

        }
    }

    private function verifyUserJefeArea() {
        try {

            // traer al usuario
            $authCurrent = Auth::user();
            // comparar el usuario con usuario jefe de area
            $jefeArea = UsuarioJefeArea::where('user_id', $authCurrent->id)->where('estado', 1)->first();
            // traer al area pertenciente del jefe de area
            $areaPerteneciente = Area::where('id', $jefeArea->area_id)->first();

            // retornar en un objeto
            return $areaPerteneciente;

        } catch (Exception $e) {

            throw new Exception('Ha ocurrido un error, inténtelo más tarde o contacte con el equipo de soporte');
            // throw new Exception($e->getMessage());

        }
    }

}


