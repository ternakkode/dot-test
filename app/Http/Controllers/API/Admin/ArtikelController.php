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
        } catch (Exception $err) {
            report($err);
            return $err;
            DB::rollBack();
        }
    }

    public function edit(simpanArtikel $request)
    {
        try {
            DB::beginTransaction();
            $this->simpanArtikelApplication->editArtikel($request->validated());
            DB::commit();
        } catch (Exception $err) {
            report($err);
            return $err;
            DB::rollBack();
        }
    }

    public function hapus($id_artikel)
    {
        try {
            DB::beginTransaction();
            $this->simpanArtikelApplication->hapusArtikel($id_artikel);
            DB::commit();
        } catch (Exception $err) {
            report($err);
            return $err;
            DB::rollBack();
        }
    }
}
