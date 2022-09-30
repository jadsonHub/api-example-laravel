<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdutoController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//rotas sem atenticação so com validacao de aplicaçao custom 
Route::middleware('isUser')->group(function(){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware('auth:sanctum')->group(function () {

    //rotas de adm autenticado
    Route::prefix('adm')->middleware('isAdmin')->group(function () {
        Route::post('/logout/{id}', [AdminController::class, 'logout']);
        Route::post('/register', [AdminController::class, 'register']);
        Route::get('/list',[AdminController::class,'index']);
        Route::get('/show/{id}', [AdminController::class, 'show']);
        Route::delete('/delete/{id}', [AdminController::class, 'destroy']);
        Route::put('/update/{id}', [AdminController::class, 'update']);
    });

    //rotas de user autenticado
    Route::post('/logout/{id}', [AuthController::class, 'logout']);
    Route::get('/show/{id}', [AuthController::class, 'show']);
    Route::delete('/delete/{id}', [AuthController::class, 'destroy']);
    Route::put('/update/{id}', [AuthController::class, 'update']);

});

