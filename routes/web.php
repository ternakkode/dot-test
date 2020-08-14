<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/login', 'AutentikasiController@login');
Route::post('/login', 'AutentikasiController@prosesLogin');

Route::middleware('cekLogin')->group(function () {
    Route::get('/', 'ArtikelController@index');
    Route::prefix('artikel')->group(function () {
        Route::get('/', 'ArtikelController@index');
        Route::get('/tambah', 'ArtikelController@tambah');
        Route::get('/edit/{id_artikel}', 'ArtikelController@edit');
    });
    
    Route::prefix('kategori')->group(function () {
        Route::get('/', 'KategoriController@index');
        Route::get('/tambah', 'KategoriController@tambah');
        Route::get('/edit/{kode_kategori}', 'KategoriController@edit');
    });
});
