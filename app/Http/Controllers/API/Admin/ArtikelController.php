<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\simpanArtikel;
use App\Domain\Artikel\Application\simpanArtikelApplication;
use Illuminate\Support\Facades\DB;
use Exception;

class ArtikelController
{
    public $simpanArtikelApplication;

    public function __construct(
        simpanArtikelApplication $simpanArtikelApplication
    ) {
        $this->simpanArtikelApplication = $simpanArtikelApplication;
    }

    public function tambah(simpanArtikel $request)
    {
        try {
            DB::beginTransaction();
            $this->simpanArtikelApplication->tambahArtikel($request->validated());
            DB::commit();
            
            return api_success('Berhasil menambahkan artikel baru');
        } catch (Exception $err) {
            report($err);
            DB::rollBack();

            return api_error('Gagal menambahkan artikel');
        }
    }

    public function edit(simpanArtikel $request)
    {
        try {
            DB::beginTransaction();
            $this->simpanArtikelApplication->editArtikel($request->validated());
            DB::commit();

            return api_success('Berhasil merubah artikel');
        } catch (Exception $err) {
            report($err);
            DB::rollBack();

            return api_error($err);
        }
    }

    public function hapus($id_artikel)
    {
        try {
            DB::beginTransaction();
            $this->simpanArtikelApplication->hapusArtikel($id_artikel);
            DB::commit();

            return api_success('Berhasil menghapus artikel');
        } catch (Exception $err) {
            report($err);
            DB::rollBack();

            return api_error('Gagal menghapus artikel');
        }
    }
}
