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
*/

Route::get('/', 'TestController@welcome');
//Listar todos los productos disponibles en la BD
Route::get('/products', 'ProductController@index');
//Insertar un producto
Route::post('/products/create', 'ProductController@store');