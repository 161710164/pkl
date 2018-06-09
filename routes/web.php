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

Route::get('index', function () {
    return view('layouts.admin');
});

Route::get('', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('kategori', 'KategoriController');
Route::resource('guru', 'GuruController');
Route::resource('fasilitas', 'FasilitasController');
Route::resource('ekskul', 'EkskulController');

Route::group(['prefix'=>'admin', 'middleware'=>['auth', 'role:admin']],function () {
    Route::resource('artikel','ArtikelController');
    Route::resource('ekskul','EkskulController');
    Route::resource('fasilitas','FasilitasController');
    Route::resource('guru','GuruController');
    Route::resource('kategori','KategoriController');
});
