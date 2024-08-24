<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        try{
            //Validar manualmente
            //NOMBRE (obligatorio, string, maximo 255 caracteres)
            if(!isset($request->name)){
                return response()->json(["status"=> 400, "message" => "El nombre es un campo obligatorio"]);
            } else{
                if(!is_string($request->name)) {
                    return response()->json(["status"=> 400, "message" => "El nombre debe ser un texto"]);
                }
                if(strlen($request->name) > 255) {
                    return response()->json(["status"=> 400, "message" => "El nombre no debe exceder los 255 caracteres"]);
                }
            }
    
            //EMAIL (obligatorio, string, maximo 255 caracteres, email valido, unico en la tabla users)
            if(!isset($request->email)){
                return response()->json(["status"=> 400, "message" => "El email es un campo obligatorio"]);
            }else{
                if(!is_string($request->email)) {
                    return response()->json(["status"=> 400, "message" => "El email debe ser un texto"]);
                }
                if(strlen($request->email) > 255) {
                    return response()->json(["status"=> 400, "message" => "El email no debe exceder los 255 caracteres"]);
                }
                $sameUser = User::where('email', $request->email)->first();
                if($sameUser) {
                    return response()->json(["status"=>400, "message" => "Ya existe un usuario con ese email"]);
                }
            }
            //PASSWORD (obligatorio,string, minimo 8 caracteres, maximo 50 caracteres)
            if(!isset($request->password)){
                return response()->json(["status"=> 400, "message" => "La contraseña es un campo obligatorio"]);
            }else{
                if(strlen($request->password) < 8){
                    return response()->json(["status"=> 400, "message" => "La contraseña debe contener mínimo 8 caracteres"]);
                }
                if(strlen($request->password) > 50){
                    return response()->json(["status" => 400, "message" => "La contraseña no debe exceder los 50 caracteres"]);
                }
            }
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            event(new Registered($user));
    
            Auth::login($user);
            $token = $user->createToken('auth_token')->plainTextToken;
            session(['api_token' => $token]);
            return response()->json(["access_token" => $token, "token_type"=> "Bearer", "user" => $user, "status" => "200"], 200);
        } catch(Exception $e){
            return response(["status" => "500", "message" => $e->getMessage()], 500);
        }
    }
}
