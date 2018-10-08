<?php

/*
|----------------------------------------------------------------------------------------
| 									General Personal Docs
|----------------------------------------------------------------------------------------
|
|	-- Para crear controladores se escribe en la consola la siguiente ruta
|	$ php artisan make:controller <AwesomeControllerName>
|
|	-- Para crear un modelo y una migración al mismo tiempo:
|	$ php artisan make:model <AwesomeModelName> -m
|
|	NOTA: El modelo se toca para cuando se hacen las consultas con Eloquent
|	(relaciones), las relaciones como tal de la DB es en archivo de la migración
|	para hacer el 'script' donde se genera toda la base de datos.
|
|	-- Ejecutar migraciones
|	$ php artisan migrate
|
|	-- Para resetear las migraciones se utiliza:
|	$ php artisan migrate:reset (TODAS LAS MIGRACIONES)
|   
|   -- Crear un seeder
| 	$ php artisan make:seeder <AwesomeNameTableSeeder>
|
|   -- Crear un factory
| 	$ php artisan make:factory <AwesomeNameTableFactory>
|
|   -- Ejecutar todos los seeder
|   $ php artisan db:seed
|	
|   -- Ejecutar el reset y los seeder después.
|   $ php artisan migrate:refresh --seed
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

	Route::prefix('/productos')->group(function () {
		Route::get('/', 'ProductsController@getAll');
	});
});