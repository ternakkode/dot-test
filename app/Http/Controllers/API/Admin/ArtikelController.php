<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TambahArtikel;
use App\Http\Requests\EditArtikel;
use App\Http\Requests\HapusArtikel;
use App\Domain\Artikel\Application\ProsesArtikelApplication;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;

class ArtikelController
{
    public $prosesArtikelApplication;

    public function __construct(
        ProsesArtikelApplication $prosesArtikelApplication
    ) {
        $this->prosesArtikelApplication = $prosesArtikelApplication;
    }

    public function tambah(TambahArtikel $request)
    {
        try {
            DB::beginTransaction();
            $this->prosesArtikelApplication->tambahArtikel($request);
            DB::commit();
            
            return api_success('Berhasil menambahkan artikel baru');
        } catch (Exception $err) {
            report($err);
            DB::rollBack();

            return api_error($err->getMessage());
        }
    }

    public function edit(EditArtikel $request)
    {
        try {
            DB::beginTransaction();
            $this->prosesArtikelApplication->editArtikel($request);
            DB::commit();

            return api_success('Berhasil merubah artikel');
        } catch (Exception $err) {
            report($err);
            DB::rollBack();

            return api_error($err);
        }
    }

    public function hapus(HapusArtikel $request)
    {
        try {
            DB::beginTransaction();
            $this->prosesArtikelApplication->hapusArtikel($request);
            DB::commit();
            return api_success('Berhasil menghapus artikel');
        } catch (Exception $err) {
            report($err);
            DB::rollBack();

            return api_error($err->getMessage());
        }
    }
}
