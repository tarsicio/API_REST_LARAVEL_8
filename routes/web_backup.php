<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
use App\Http\Controllers\NotificarController;
use Illuminate\Support\Facades\Route;
use App\Models\User\User;
//use App\Http\Controllers\User\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('idioma/{lang}', 'Lenguaje\LenguajeController@cambioLenguaje')
            ->name('idioma.cambioLenguaje');

Route::get('/deny', function () {    
    return view('deny');
});

Route::get('/check_your_mail', function () {
    return view('adminlte::mail.check_your_mail');
});

Route::get('/', function () {
    return view('welcome');
});

/**
 * Se creó un middleware('permiso:user,view') el cual verifica antes de 
 * acceder al recurso solicitado si el usuario tiene permiso de ver dicho recurso.
 * Este middleware es parte de la seguridad de la aplicación en conjunto cn los permisos
 * asignados a cada rol. 
 * /
 // *********************************************************************************************************
    /*
    * Grupo Middleware para Autenticar y verifcar que tiene Permiso asociado a su Rol
    */
// *********************************************************************************************************
Route::group(['middleware' => 'auth'], function () {

    Route::get('/mail', 'Mail\MailController@index')->name('mail.index');
    Route::get('/homework', 'Tarea\TareaController@index')->name('homework.index');
    // *********************************************************************************************************
    /*
    * Rutas de Usuarios, para todas las operaciones, con el Middleware (permiso) Integrado, para cada caso.
    */
    Route::get('/notificaciones', 'Notification\NotificationController@index')->name('notificaciones.index');
    Route::get('/notificaciones/list', 'Notification\NotificationController@getNotifications')->name('notificaciones.list');
    Route::get('/notificaciones/read/{id}', 'Notification\NotificationController@setNotifications')->name('notificaciones.setNotifications');
    /*
    * Fin de las Rutas de Usuarios, para todas las operaciones
    */
    // *********************************************************************************************************
    // *********************************************************************************************************
    /*
    * Rutas de Usuarios, para todas las operaciones, con el Middleware (permiso) Integrado, para cada caso.
    */
    Route::get('/users', 'User\UserController@index')->name('users.index')->middleware('permiso:user,view');
    Route::get('/users/create', 'User\UserController@create')->name('users.create')->middleware('permiso:user,add');
    Route::post('/users', 'User\UserController@store')->name('users.store')->middleware('permiso:user,add');
    Route::get('/users/{user}/view', 'User\UserController@view')->name('users.view')->middleware('permiso:user,view');
    Route::get('/users/{user}/edit', 'User\UserController@edit')->name('users.edit')->middleware('permiso:user,edit');
    Route::post('/users/{user}', 'User\UserController@update')->name('users.update')->middleware('permiso:user,update');
    Route::get('/users/{user}/delete', 'User\UserController@destroy')->name('users.destroy')->middleware('permiso:user,delete');
    Route::get('/users/list', 'User\UserController@getUsers')->name('users.list')->middleware('permiso:user,view');
    Route::get('/users/profile', 'User\UserController@profile')->name('users.profile');
    Route::post('/users/profile/{id}', 'User\UserController@update_avatar')->name('users.profile')->middleware('permiso:user,update');
    Route::get('/users/usuarioRol', 'User\UserController@usuarioRol')->name('users.usuarioRol');
    Route::get('/users/notificationsUser', 'User\UserController@notificationsUser')->name('users.notificationsUser');
    Route::get('/users/print', 'User\UserController@usersPrint')->name('users.usersPrint')->middleware('permiso:user,print');
    Route::get('/users/color_view', 'User\UserController@colorView')->name('users.colorView');
    Route::get('/users/color_change', 'User\UserController@colorChange')->name('users.colorChange');
    /*
    * Fin de las Rutas de Usuarios, para todas las operaciones
    */
    // *********************************************************************************************************
    // *********************************************************************************************************
    /*
    * Rutas de Permiso, para todas las operaciones, con el Middleware (permiso) Integrado, para cada caso.
    */
    Route::get('/permisos', 'Permiso\PermisoController@index')
    ->name('permisos.index')->middleware('permiso:permiso,view');

    Route::get('/permisos/list', 'Permiso\PermisoController@getModulos')
    ->name('permisos.list')->middleware('permiso:permiso,view');

    Route::get('/permisos/create', 'Permiso\PermisoController@create')
    ->name('permisos.create')->middleware('permiso:permiso,add');

    Route::post('/permisos','Permiso\PermisoController@store')
    ->name('permisos.store')->middleware('permiso:permiso,add');

    Route::post('/permisos/{permiso}','Permiso\PermisoController@show')
    ->name('permisos.show')->middleware('permiso:permiso,view');

    Route::get('/permisos/{permiso}/edit','Permiso\PermisoController@edit')
    ->name('permisos.edit')->middleware('permiso:permiso,edit');
// Parte importante para Actualizar los cambios realizados a los permisos .//////////////////
    Route::post('/permisos/{id}/{accion}/{allow_deny}','Permiso\PermisoController@update')
    ->name('permisos.update')->middleware('permiso:permiso,update');

    Route::post('/permisos/{id}/{allow_deny}','Permiso\PermisoController@updateAllPermisos')
    ->name('permisos.updateAllPermisos');

    Route::get('/permisos/{modulo_id}/{rol_id}','Permiso\PermisoController@getPermisos')
    ->name('permisos.getPermisos')->middleware('permiso:permiso,view');
// Parte importante para Actualizar los cambios realizados a los permisos .//////////////////
    Route::post('/permisos/{permiso}/delete','Permiso\PermisoController@destroy')
    ->name('permisos.destroy')->middleware('permiso:permiso,delete');

    Route::get('/permisos/print', 'Permiso\PermisoController@permisoPrint')
    ->name('permisos.permisoPrint')->middleware('permiso:permiso,print');    
    /*
    * Fin de las Rutas de Permiso, para todas las operaciones
    */
    // *********************************************************************************************************
    // *********************************************************************************************************    
    /*
    * Rutas de Roles, para todas las operaciones, con el Middleware (permiso) Integrado, para cada caso.
    */
    Route::get('/rols', 'Rol\RolController@index')->name('rols.index')->middleware('permiso:rol,view');
    Route::get('/rols/create', 'Rol\RolController@create')->name('rols.create')->middleware('permiso:rol,add');
    Route::post('/rols', 'Rol\RolController@store')->name('rols.store')->middleware('permiso:rol,add');
    Route::get('/rols/{rol}/show', 'Rol\RolController@show')->name('rols.show')->middleware('permiso:rol,view');
    Route::get('/rols/{rol}/edit', 'Rol\RolController@edit')->name('rols.edit')->middleware('permiso:rol,edit');
    Route::post('/rols/{rol}', 'Rol\RolController@update')->name('rols.update')->middleware('permiso:rol,update');
    Route::get('/rols/{rol}/delete', 'Rol\RolController@destroy')->name('rols.destroy')->middleware('permiso:rol,delete');
    Route::get('/rols/list', 'Rol\RolController@getRols')->name('rols.list')->middleware('permiso:rol,view');
    Route::get('/rols/print', 'Rol\RolController@rolsPrint')->name('rols.rolsPrint')->middleware('permiso:rol,print');        
    /*
    * Fin de las Rutas de Usuarios, para todas las operaciones
    */
    // *********************************************************************************************************
    // *********************************************************************************************************
    /*
    * Rutas de Roles, para todas las operaciones, con el Middleware (permiso) Integrado, para cada caso.
    */
    Route::get('/modulos', 'Modulo\ModuloController@index')->name('modulos.index')->middleware('permiso:modulo,view');
    Route::get('/modulos/create', 'Modulo\ModuloController@create')->name('modulos.create')->middleware('permiso:modulo,add');
    Route::post('/modulos', 'Modulo\ModuloController@store')->name('modulos.store')->middleware('permiso:modulo,add');
    Route::get('/modulos/{modulo}/show', 'Modulo\ModuloController@show')->name('modulos.show')->middleware('permiso:modulo,view');
    Route::get('/modulos/{modulo}/edit', 'Modulo\ModuloController@edit')->name('modulos.edit')->middleware('permiso:modulo,edit');
    Route::post('/modulos/{modulo}', 'Modulo\ModuloController@update')->name('modulos.update')->middleware('permiso:modulo,update');
    Route::get('/modulos/{modulo}/delete', 'Modulo\ModuloController@destroy')->name('modulos.destroy')->middleware('permiso:modulo,delete');
    Route::get('/modulos/list', 'Modulo\ModuloController@getModulos')->name('modulos.list')->middleware('permiso:modulo,view');
    Route::get('/modulos/print', 'Modulo\ModuloController@modulosPrint')->name('modulos.modulosPrint')->middleware('permiso:modulo,print');               
    /*
    * Fin de las Rutas de Usuarios, para todas las operaciones
    */
    // *********************************************************************************************************
    // *********************************************************************************************************

    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard.dashboard');
});
// *********************************************************************************************************
    /*
    * FIN del Grupo Middleware para Autenticar y verifcar que tiene Permiso asociado a su Roll
    */
// *********************************************************************************************************

// La presente Ruta se encarga de validar los datos enviados al Correo de Usuario que se Registró
Route::get('register/confirm/{confirmation_code}', 'Auth\RegisterController@confirm')->name('auth.confirm');
// *********************************************************************************************************
// *********************************************************************************************************