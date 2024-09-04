<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UsuarioAdministrador;
use App\Models\UsuarioJefeArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{
    public function index()
    {
        $access = FunctionHelperController::verifyAdminAccess();
        if (!$access) {
            return redirect('dashboard')->with('error', 'No tiene permitos para ejecutar esta acción. No lo intente denuevo o puede ser baneado.');
        }

        $users = User::get();

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
        }
        // return $users;
        return view('inspiniaViews.accounts.index', ['users' => $users]);

    }

    public function activarInactivar($user_id){
        DB::beginTransaction();
        $user = User::findOrFail($user_id);
        if($user){
            $superAdmin = FunctionHelperController::verifySuperAdmin($user_id);
            if($superAdmin){
                return redirect()->route('accounts.index')->with('error','No se puede inactivar a un super administrador.');
            }
            // $user->update(["estado" => !$user->estado]);
            $user->estado = !$user->estado;

            $user->save();
            // return $user;
        }
        DB::commit();
        return redirect()->route('accounts.index')->with('success','Se modificó correctamente el estado del usuario.');
    }
}
