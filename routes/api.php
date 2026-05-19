<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API SOPAD
|--------------------------------------------------------------------------
*/

Route::get('/proyectos', function () {

    return response()->json([
        'ok' => true,
        'mensaje' => 'Lista de proyectos',
        'data' => DB::table('proyecto')->get()
    ]);

});

Route::get('/materiaprima', function () {

    return response()->json([
        'ok' => true,
        'mensaje' => 'Lista de materia prima',
        'data' => DB::table('materia_prima')->get()
    ]);

});

Route::get('/ventas', function () {

    return response()->json([
        'ok' => true,
        'mensaje' => 'Lista de ventas',
        'data' => DB::table('ventas_anuales')->get()
    ]);

});

/*
|--------------------------------------------------------------------------
| USUARIO AUTENTICADO
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    return $request->user();

});