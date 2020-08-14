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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('kategori')->group(function () {
    Route::post('tambah', 'API\KategoriController@tambah')->name('tambah-kategori');
    Route::put('edit', 'API\KategoriController@edit')->name('edit-kategori');
    Route::get('hapus/{kode_kategori}', 'API\KategoriController@hapus');
});
Route::prefix('artikel')->group(function () {
    Route::post('tambah', 'API\ArtikelController@tambah')->name('tambah-artikel');
    Route::post('edit', 'API\ArtikelController@edit')->name('edit-artikel');
    Route::get('hapus/{id_artikel}', 'API\ArtikelController@hapus');
    Route::post('upload/photo', 'API\ArtikelController@uploadPhoto')->name('upload-photo');
});