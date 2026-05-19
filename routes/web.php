<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| CONTROLADORES
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\MateriaPrimaController;
use App\Http\Controllers\LaborDirectaController;
use App\Http\Controllers\VentasAnualesController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\InversionController;
use App\Http\Controllers\ProyeccionFinancieraController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Página principal
Route::get('/', [AuthController::class, 'showLogin']);

// LOGIN
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'processLogin'])
    ->name('login.process');

// 2FA
Route::get('/2fa', [AuthController::class, 'twoFactorIndex'])
    ->name('twofactor.index');

Route::post('/2fa', [AuthController::class, 'verifyTwoFactor'])
    ->name('twofactor.verify');

/*
|--------------------------------------------------------------------------
| REGISTRO PÚBLICO
|--------------------------------------------------------------------------
*/

Route::resource('admon/usuarios', UsuariosController::class)
    ->only(['create', 'store'])
    ->names('usuarios');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.session'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/admon', function () {
        return view('cpanel.inicio');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | USUARIOS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'admon/usuarios',
        UsuariosController::class
    )->except(['create', 'store'])
     ->names('usuarios');

    /*
    |--------------------------------------------------------------------------
    | EVENTOS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'admon/eventos',
        EventosController::class
    );

    /*
    |--------------------------------------------------------------------------
    | PROYECTOS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'admon/proyecto',
        ProyectoController::class
    )->names('proyecto');

    /*
    |--------------------------------------------------------------------------
    | MÓDULOS POR PROYECTO
    |--------------------------------------------------------------------------
    */

    Route::prefix('admon/proyecto/{id_proyecto}')
        ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | MATERIA PRIMA
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'materiaprima',
            MateriaPrimaController::class
        );

        /*
        |--------------------------------------------------------------------------
        | LABOR DIRECTA
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'labordirecta',
            LaborDirectaController::class
        );

        /*
        |--------------------------------------------------------------------------
        | VENTAS ANUALES
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'ventasanuales',
            VentasAnualesController::class
        )->names('ventas');

        /*
        |--------------------------------------------------------------------------
        | INVERSIÓN
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'inversion',
            InversionController::class
        )->names('inversion');

        /*
        |--------------------------------------------------------------------------
        | PROYECCIÓN FINANCIERA
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'proyeccion',
            ProyeccionFinancieraController::class
        )->names('proyeccion');

    });

    /*
    |--------------------------------------------------------------------------
    | GRÁFICAS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/materiaprima/grafica',
        function () {

            $nombres = DB::table('materia_prima')
                ->pluck('nombre_articulo');

            $totales = DB::table('materia_prima')
                ->pluck('total');

            return view(
                'cpanel.materiaprima.grafica',
                compact('nombres', 'totales')
            );
        }
    );

    /*
    |--------------------------------------------------------------------------
    | REPORTES PDF
    |--------------------------------------------------------------------------
    */

    Route::get(
        'admon/reportes/pdf',
        [ReportesController::class, 'GenerarPDF']
    )->name('reportes.pdf');

    Route::get(
        '/admon/reporte/pdf1',
        [ReporteController::class, 'GenerarPDF']
    )->name('reporte.pdf1');

    /*
    |--------------------------------------------------------------------------
    | EXCEL MATERIA PRIMA
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reporte/materiaprima/excel/{id_proyecto}',
        [ExportController::class, 'GenerarExcelMateriaPrima']
    );

    /*
    |--------------------------------------------------------------------------
    | REPORTE FINANCIERO
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reporte-financiero/{id_proyecto}',
        [ReportesController::class, 'reporteFinanciero']
    );

    Route::get(
        '/reporte-financiero/exportar/{id_proyecto}',
        [ExportController::class, 'reporteExcel']
    );

    /*
    |--------------------------------------------------------------------------
    | PERFIL
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/perfil',
        [AuthController::class, 'perfil']
    )->name('perfil');

    Route::post(
        '/perfil/foto',
        [AuthController::class, 'subirFoto']
    )->name('perfil.foto');

    Route::post(
        '/perfil/foto/eliminar',
        [AuthController::class, 'eliminarFoto']
    )->name('perfil.foto.eliminar');

    Route::post(
        '/cambiar-password',
        [AuthController::class, 'cambiarPassword']
    )->name('password.cambiar');

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', function () {

        session()->flush();

        return redirect('/login');

    })->name('logout');

    /*
    |--------------------------------------------------------------------------
    | DASHBOARDS POR ROL
    |--------------------------------------------------------------------------
    */

    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/profesor', function () {
        return view('profesor.dashboard');
    })->name('profesor.dashboard');

    Route::get('/estudiante', function () {
        return view('estudiante.dashboard');
    })->name('estudiante.dashboard');

    /*
    |--------------------------------------------------------------------------
    | GEOLOCALIZACIÓN
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/guardar-ubicacion',
        [MateriaPrimaController::class, 'guardarUbicacion']
    );

});