<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('jwt.verify')->group(function () {
    Route::prefix('kategori')->group(function () {
        Route::post('tambah', 'API\Admin\KategoriController@tambah')->name('tambah-kategori');
        Route::put('edit', 'API\Admin\KategoriController@edit')->name('edit-kategori');
        Route::get('hapus/{kode_kategori}', 'API\Admin\KategoriController@hapus');
    });
    Route::prefix('artikel')->group(function () {
        Route::post('tambah', 'API\Admin\ArtikelController@tambah')->name('tambah-artikel');
        Route::post('edit', 'API\Admin\ArtikelController@edit')->name('edit-artikel');
        Route::get('hapus/{id_artikel}', 'API\Admin\ArtikelController@hapus');
        Route::post('upload/photo', 'API\Admin\ArtikelController@uploadPhoto')->name('upload-photo');
    });
});
Route::prefix('v1')->group(function () {
    Route::prefix('artikel')->group(function () {
        Route::get('/', 'API\v1\ArtikelController@semua');
        Route::get('/{id_artikel}', 'API\v1\ArtikelController@detail')->where('id_artikel', '[0-9]+');
    });
    Route::prefix('kategori')->group(function () {
        Route::get('/', 'API\v1\KategoriController@semua');
    });
});