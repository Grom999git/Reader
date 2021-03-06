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

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

Route::get('/register', 'Auth\RegisterController@index')->name('register');
Route::post('/register', 'Auth\RegisterController@create');

Route::get('/login', 'Auth\LoginController@login')->name('login');
Route::post('/login', 'Auth\LoginController@authenticate');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/rss', 'ReaderController@index')->name('rss');