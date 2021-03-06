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
|	-- Para las relaciones en eloquent cuando no se deja predefinido el id_table como 'id', 
|	se tiene que especificar el id en las relaciones de los modelos.
|	$this->hasMany('Model::class', 'foreign_key', 'other_key');
|	$this->hasOne('Model::class', 'foreign_key', 'other_key');
|	$this->belongsTo('Model::class', 'foreign_key', 'other_key');
|	$this->belongsToMany('Model::class', 'foreign_key', 'other_key');
|
*/

Route::get('/', function () {
    return view('welcome');
});

// main url to the api for the project
Route::prefix('api/v1')->group(function () {

	//main url and urls to CRUD data on table categories
	Route::prefix('/categories')->group(function () {
		Route::get('/read/{method?}', 'CategoriesController@getAll');
		Route::get('/create', 'CategoriesController@create');
		Route::get('/update', 'CategoriesController@update');
		Route::get('/delete', 'CategoriesController@delete');
	});

	Route::prefix('/products')->group(function () {
		Route::get('/read/{method?}', 'ProductsController@getAll');
		Route::get('/create', 'ProductsController@create');
		Route::get('/delete', 'ProductsController@delete');
		Route::get('/update', 'ProductsController@update');
	});

	Route::prefix('/users')->group(function () {
		Route::get('/read/{id}/{method?}', 'UsersController@getAll');
		Route::get('/create', 'UsersController@create');
		Route::get('/delete', 'UsersController@delete');
		Route::get('/update', 'UsersController@update');
		Route::get('/login', 'UsersController@login');
	});

	Route::prefix('/sales')->group(function () {
		Route::get('/read/{method?}', 'SalesController@getAll');
		Route::get('/create', 'SalesController@create');
		Route::get('/delete', 'SalesController@delete');
		Route::get('/update', 'SalesController@update');
	});

	Route::prefix('/sales_products')->group(function () {
		Route::get('/read/{method?}', 'SaleProductController@getAll');
		Route::get('/create', 'SaleProductController@create');
		Route::get('/delete', 'SaleProductController@delete');
	});

	Route::prefix('/forecast')->group(function () {
		Route::get('/read/{method?}', 'ForecastController@getAll');
		Route::get('/create', 'ForecastController@create');
		Route::get('/delete', 'ForecastController@delete');
	});

});