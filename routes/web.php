<?php
use App\Routes\Route;
use App\Controllers\HomeController;
use App\Controllers\ClientController;

Route::get('', 'HomeController@index');
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/home/index', 'HomeController@index');
Route::get('/list_posts', 'PostController@index');
Route::get('/posts/create', 'PostController@create');
Route::get('/edit_post', 'PostController@edit');
Route::post('/list_posts', 'PostController@update');
Route::post('/posts/create', 'PostController@store');
Route::get('/posts/delete', 'PostController@delete');

Route::dispatch();
?>