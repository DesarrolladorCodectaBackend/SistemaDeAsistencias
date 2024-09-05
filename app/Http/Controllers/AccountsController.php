<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Candidatos;
use App\Models\User;
use App\Models\UsuarioAdministrador;
use App\Models\UsuarioJefeArea;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{
    public function index()
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if (!$access) {
            return redirect('dashboard')->with('error', 'No tiene permisos para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        try {
            $users = User::get();
            $areas = Area::get();

            foreach ($users as $user) {
                $jefe = UsuarioJefeArea::where('user_id', $user->id)->first();
                $rol = 'Sin rol';
                if ($jefe) {
                    $rol = 'Jefe de Área';
                }
                $admin = UsuarioAdministrador::where('user_id', $user->id)->first();
                if ($admin) {
                    $rol = 'Administrador';
                }
                $user->rol = $rol;

                if ($user->rol === 'Jefe de Área') {
                    $areasJefe = FunctionHelperController::getAreasJefe($user->id);
                    $user->areas = $areasJefe;
                }
            }
            // return $users;
            return view('inspiniaViews.accounts.index', ['users' => $users, "areas" => $areas]);
        } catch (Exception $e) {
            return redirect('dashboard')->with('error', 'Ocurrió un error al acceder a la vista. Si el error persiste comuniquese con su equipo de soporte.');
        }
    }

    public function activarInactivar($user_id)
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if (!$access) {
            return redirect('dashboard')->with('error', 'No tiene permisos para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try {
            $user = User::findOrFail($user_id);
            if ($user) {
                $superAdmin = FunctionHelperController::verifySuperAdmin($user_id);
                if ($superAdmin) {
                    return redirect()->route('accounts.index')->with('error', 'No se puede inactivar a un super administrador.');
                }
                // $user->update(["estado" => !$user->estado]);
                $user->estado = !$user->estado;

                $user->save();
                // return $user;
            }
            DB::commit();
            return redirect()->route('accounts.index')->with('success', 'Se modificó correctamente el estado del usuario.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('accounts.index')->with('error', 'Ocurrió un error al realizar la acción. Si el error persiste comuniquese con su equipo de soporte.');
        }
    }

    public function update(Request $request, $user_id)
    {
        // return $request;
        $access = FunctionHelperController::verifyAdminAccess();
        if (!$access) {
            return redirect('dashboard')->with('error', 'No tiene permisos para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        DB::beginTransaction();
        try {
            $user = User::findOrFail($user_id);
            if ($user) {
                //VALIDACIONES
                $errors = [];
                //Name(Requerido, String, Minimo 1)
                if (!isset($request->name)) {
                    $errors['name'.$user_id] = 'El nombre es un campo requerido';
                } else{
                    if(!is_string($request->name)){
                        $errors['name'.$user_id] = 'El nombre debe ser un texto';
                    }else{
                        if(strlen($request->name) < 1){
                            $errors['name'.$user_id] = 'El nombre debe ser mayor a 1 caracter';
                        }
                    }
                }
                //Apellido(Requerido, String, Minimo 1)
                if (!isset($request->apellido)) {
                    $errors['apellido'.$user_id] = 'El apellido es un campo requerido';
                } else{
                    if(!is_string($request->apellido)){
                        $errors['apellido'.$user_id] = 'El apellido debe ser un texto';
                    }else{
                        if(strlen($request->apellido) < 1){
                            $errors['apellido'.$user_id] = 'El apellido debe ser mayor a 1 caracter';
                        }
                    }
                }
                //Email(Requerido, String, Minimo 1)
                if (!isset($request->email)) {
                    $errors['email'.$user_id] = 'El email es un campo requerido';
                } else{
                    if(!is_string($request->email)){
                        $errors['email'.$user_id] = 'El email debe ser un texto';
                    }else{
                        if(strlen($request->email) < 1){
                            $errors['email'.$user_id] = 'El email debe ser mayor a 1 caracter';
                        }
                    }
                    $sameUserEmail = User::where('email', $request->email)->whereNot('id', $user_id)->first();
                    if($sameUserEmail){
                        $errors['email'.$user_id] = 'ya hay un usuario registrado con ese email';
                    }
                }
                if(!empty($errors)) {
                    $errors['user'] = $user_id;
                    // return $errors;
                    return redirect()->route('accounts.index')->with('userError', $user_id)->withErrors($errors)->withInput();
                }

                $areas = [];
                if(isset($request->areas_id)){
                    $areas = $request->areas_id;
                }

                //Ver si es un administrador o si es un Jefe
                $userData = FunctionHelperController::getUserRolById($user_id);
                if($userData['isBoss']){
                    // $newData = 
                    //Buscar el colaborador asociado por el email
                    FunctionHelperController::modifyColabByBoss($user, $request);
                    //Modificar Areas
                    foreach($areas as $area_id){
                        $usuariosArea = UsuarioJefeArea::where('user_id', $user_id)->where('area_id', $area_id)->first();
                        if (!$usuariosArea) {
                            UsuarioJefeArea::create([
                                'user_id' => $user->id,
                                'area_id' => $area_id,
                                'estado' => 1,
                            ]);
                        } else if ($usuariosArea->estado == 0) {
                            $usuariosArea->update(['estado' => 1]);
                        }
                    }
                    $usuariosAreasInactivas = UsuarioJefeArea::where('user_id', $user_id)->where('estado', 1)->whereNotIn('area_id', $areas)->get();
                    foreach($usuariosAreasInactivas as $inactiveUser){
                        $inactiveUser->update(['estado' => 0]);;
                    }

                } else if($userData['isAdmin']){
                    $user->update([
                        'name'=> $request->name,
                        'apellido'=> $request->apellido,
                        'email' => $request->email
                    ]);
                }
                // return $userData;

                DB::commit();
                return redirect()->route('accounts.index')->with('success', 'Se actualizó correctamente al usuario.');
            } else{
                return redirect()->route('accounts.index')->with('error', 'No se encontró un usuario con ese id.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            // return $e;
            return redirect()->route('accounts.index')->with('error', 'Ocurrió un error al realizar la acción. Si el error persiste comuniquese con su equipo de soporte.');
        }
    }
}
