<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//REGISTER & LOGIN
Route::post('register', [RegisteredUserController::class, 'store']);
Route::post('login', [AuthenticatedSessionController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function (){
        //LOGOUT
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);

        //NOTIFICATIONS
        Route::get('notificaciones', [NotificationController::class, 'index']);

});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//         // return $request->user();
// });