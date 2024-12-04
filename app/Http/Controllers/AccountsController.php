<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Candidatos;
use App\Models\Colaboradores;
use App\Models\User;
use App\Models\UsuarioAdministrador;
use App\Models\UsuarioJefeArea;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\UsuarioCreadoMailable;

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

    public function create(){
        $access = FunctionHelperController::verifyAdminAccess();
        if (!$access) {
            return redirect('dashboard')->with('error', 'No tiene permisos para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        $colaboradores = Colaboradores::with('candidato')->whereNot('estado', 2)->get();
        $areas = Area::where(["estado" => 1])->get();
        return view('inspiniaViews.accounts.create', ["colaboradores" => $colaboradores, "areas" => $areas]);
    }

    public function store(Request $request){
        // return $request;
        $access = FunctionHelperController::verifyAdminAccess();
        if (!$access) {
            return redirect('dashboard')->with('error', 'No tiene permisos para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }
        try{
            DB::beginTransaction();
            //VALIDACIONES
            $errors = [];
            //Type (Required)
            if(!isset($request->type)){
                $errors['type'] = 'El tipo de usuario es requerido.';
            }
            //Email (Required, min: 3, max:100,unique)
            if(!isset($request->email)) {
                $errors['email'] = 'El email es requerido.';
            }else{
                if(strlen($request->email) < 3) {
                    $errors['email'] = 'El email debe tener al menos 3 caracteres.';
                } elseif (strlen($request->email) > 100) {
                    $errors['email'] = 'El email no debe tener más de 100 caracteres.';
                } else{
                    $userEmail = User::where('email', $request->email)->first();
                    if ($userEmail) {
                        $errors['email'] = 'El email ya se encuentra registrado.';
                    }
                }
            }
            //Name (Required, min: 1, max:100)
            if(!isset($request->name)) {
                $errors['name'] = 'El nombre es requerido.';
            } else{
                if(strlen($request->name) < 1) {
                    $errors['name'] = 'El nombre debe tener al menos 1 caracter.';
                } else if (strlen($request->name) > 100) {
                    $errors['name'] = 'El nombre no debe tener más de 100 caracteres.';
                }
            }
            //Apellido (Required, min: 1, max:100)
            if(!isset($request->apellido)) {
                $errors['apellido'] = 'El apellido es requerido.';
            } else{
                if(strlen($request->apellido) < 1) {
                    $errors['apellido'] = 'El apellido debe tener al menos 1 caracter.';
                } else if (strlen($request->apellido) > 100) {
                    $errors['apellido'] = 'El apellido no debe tener más de 100 caracteres.';
                }
            }
            //Contraseña (Required, min: 8, max:100)
            if(!isset($request->password)) {
                $errors['password'] = 'La contraseña es requerida.';
            } else{
                if(strlen($request->password) < 8) {
                    $errors['password'] = 'La contraseña debe tener al menos 8 caracter.';
                } else if (strlen($request->password) > 100) {
                    $errors['password'] = 'La contraseña no debe tener más de 100 caracteres.';
                }
            }
            //Confirmacion de Contraseña(Required, min: 8, max:100, igual a contraseña)
            if(!isset($request->confirm_password)) {
                $errors['confirm_password'] = 'La contraseña de confirmación es requerida.';
            } else{
                if(strlen($request->confirm_password) < 8) {
                    $errors['confirm_password'] = 'La contraseña de confirmación debe tener al menos 8 caracter.';
                } else if (strlen($request->confirm_password) > 100) {
                    $errors['confirm_password'] = 'La contraseña de confirmación no debe tener más de 100 caracteres.';
                }else{
                    if($request->password != $request->confirm_password) {
                        $errors['confirm_password'] = 'Las contraseñas no coinciden.';
                    }
                }
            }
            //ColaboradorId (Puede ser usado solo si el tipo es igual a 2, pero no es requerido, integer, existe en la tabla colaboradores)
            $SelectedColaborador = null;
            $colaboradorExists = false;
            if($request->type == 2) {
                if(isset($request->colaborador_id)) {
                    $colaborador = Colaboradores::with('candidato')->whereNot('estado', 2)->where('id', $request->colaborador_id)->first();
                    if($colaborador){
                        $SelectedColaborador = $colaborador;
                        $colaboradorExists = true;
                    }else{
                        $errors['colaborador_id'] = 'No existe un colaborador con ese id.';
                    }
                }
            }

            //AreasId (Requerido si el tipo es igual a 2, array, minimo 1)
            if($request->type == 2){
                if(!isset($request->areas_id)){
                    $errors['areas_id'] = 'El área es requerida si el usuario es un jefe de Área.';
                } else if(count($request->areas_id) < 1) {
                    $errors['areas_id'] = 'Debe seleccionar al menos un área.';
                }
            }

            if(!empty($errors)) {
                return redirect()->route('accounts.create')->withErrors($errors)->withInput();
            }

            //Se crea el usuario Base
            $user = User::create([
                'name' => $request->name,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            //Si el type es 1 se crea un administrador, si es 2 se crea como jefe de área
            if($request->type == 1) {
                UsuarioAdministrador::create([
                    'user_id' => $user->id
                ]);
            } else if($request->type == 2){
                if($colaboradorExists){
                    //Se actualiza el colaborador para que tenga los datos del usuario creado
                    $candidato = $SelectedColaborador->candidato;
                    $candidato->update([
                        'nombre' => $user->name,
                        'apellido' => $user->apellido,
                        'correo' => $user->email,
                    ]);
                }
                foreach($request->areas_id as $area_id) {
                    UsuarioJefeArea::create([
                        'user_id' => $user->id,
                        'area_id' => $area_id,
                    ]);
                }
            }
            Mail::to($request->email)->send(new UsuarioCreadoMailable($request->email, $request->password, $request->name." ".$request->apellido, $request->type));

            DB::commit();
            return redirect()->route('accounts.index')->with('success', 'Usuario creado exitosamente.');

        } catch(Exception $e){
            // return $e;
            DB::rollback();
            return redirect()->route('accounts.create')->with('error', 'Ocurrió un error al realizar la acción. Si el error persiste comuniquese con su equipo de soporte.');
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
                $userData = FunctionHelperController::getUserRolById($user_id);
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
                    $candidato = FunctionHelperController::findUserCandidato(1, $user->email);
                    if($candidato != null){
                        $conflict = FunctionHelperController::verifyEmailCandidatoConflict($request->email, $candidato->id);
                        if($conflict){
                            $errors['email'.$user_id] = 'ya hay un colaborador usuario registrado con ese email';
                        }
                    }
                    if($userData['isAdmin']){
                        $conflict = FunctionHelperController::verifyEmailCandidatoConflict($request->email);
                        if($conflict){
                            $errors['email'.$user_id] = 'ya hay un colaborador registrado con ese email';
                        }
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
                    FunctionHelperController::modifyColabByUser($user, $request);
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
