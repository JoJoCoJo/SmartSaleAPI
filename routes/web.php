<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
|
|	-- Para crear controladores se escribe en la consola la siguiente ruta
|	$ php artisan make:controller <AwesomeControllerName>
|
|	-- Para crear un modelo y una migración al mismo tiempo:
|	$ php artisan make:model <AwesomeModelName> -m
|	
|	-- Para resetear las migraciones se utiliza:
|	$ php artisan migrate:reset (TODAS LAS MIGRACIONES)
|
|	-- Ejecutar migraciones
|	$ php artisan migrate
|
|	NOTA (2): El modelo se toca para cuando se hacen las consultas con Eloquent
|	(relaciones), las relaciones como tal de la DB es en archivo de la migración
|	para hacer el 'script' donde se genera toda la base de datos.
|	
|	para agregar una ruta
|	Route::get('/<Ruta>', '<AwesomeControllerName>@functionOnController');
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api/v1')->group(function () {
	Route::prefix('/categorias')->group(function () {
		Route::get('/', 'CategoriesController@getAll');
	});
});