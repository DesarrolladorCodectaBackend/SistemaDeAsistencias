<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();


        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        session(['api_token' => $token]);
        return response()->json(["access_token" => $token, "token_type"=> "Bearer", "user" => $user, "status" => "success"], 200);
    }
    public function login(Request $request)
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json(["status" => 401, "message" => "Email o contraseña incorrectos."], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json(["access_token" => $token, "token_type"=> "Bearer", "user" => $user, "status" => "200"], 200);
    }

    /**
     * LOGOUT
     * Destroy an authenticated session.
     */
    // public function destroy()
    // {
    //     $user = auth()->user();

    //     // Auth::guard('web')->logout();

    //     // $request->session()->invalidate();

    //     // $request->session()->regenerateToken();

    //     if ($user) {
    //         $user->tokens()->delete();
    //     }

    //     return response()->json(["status" => "success", "message" => "Logout successfully"], 200);
    // }
    public function destroy()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                // Si el usuario no está autenticado, devuelve un mensaje de error
                return response()->json(["status" => "401", "message" => "Unauthorized"], 401);
            }

            // Elimina los tokens del usuario autenticado
            $user->tokens()->delete();

            return response()->json(["status" => "200", "message" => "Logout successfully"], 200);
        } catch (Exception $e) {
            // Captura cualquier excepción y devuelve un mensaje de error
            return response()->json(["status" => "500", "message" => "An error occurred"], 500);
        }
    }
}
