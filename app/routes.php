<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return Redirect::to('index.php/tipoPermiso');
});

//-------------------------------------------
// Login
//-------------------------------------------
Route::get('login', function() {
    return View::make('modulos.seguridad.login')
            ->with('login_errors', false)
        ->with('login_no_app', false)
        ->with('login_no_active', false);
});

Route::post('login', function() {
    $userdata = array(
        'username' => Input::get('username'),
        'password' => Input::get('password')
    );
    if ( Auth::attempt($userdata) )
    {
        // Revisamos que el usuario se encuentre definido entre
        // los usuarios que pueden ocupar la aplicacion
        $model = User::where('name', '=', Auth::user()->username)->first();
        if(isset($model)) {
            if($model->active) {
                return Redirect::to('/tipoPermiso');
            } else {
                // El usuario no esta activo
                Auth::logout();
                return View::make('modulos.seguridad.login')
                    ->with('login_no_active', true)
                    ->with('login_errors', false)
                    ->with('login_no_app', false);
            }
        } else {
            // Deslogueamos y enviamos al inicio de sesion
            Auth::logout();
            return View::make('modulos.seguridad.login')
            ->with('login_no_app', true)
            ->with('login_errors', false)
            ->with('login_no_active', false);
        }
    }
    else
    {
        return View::make('modulos.seguridad.login')
            ->with('login_errors', true)
            ->with('login_no_app', false)
            ->with('login_no_active', false);
    }
});

Route::get('logout', function() {
    Auth::logout();
    return View::make('modulos.seguridad.login')
            ->with('login_errors', false)
            ->with('login_no_app', false)
            ->with('login_no_active', false);
});

//-------------------------------------------
// RESTful Controllers
//-------------------------------------------
Route::controller('tipoPermiso', 'TipoPermisoController');
Route::controller('empresa', 'EmpresaController');
Route::controller('proyecto', 'ProyectoController');
Route::controller('puesto', 'PuestoController');
Route::controller('empleado', 'EmpleadoController');