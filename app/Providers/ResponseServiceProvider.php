<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    private $status;
    private $keterangan;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('tambahArtikel', function ($status) {
            if ($status) {
                $this->status = "Berhasil";
                $this->keterangan = "Berhasil menambahkan Artikel";
            } else {
                $this->status = "Gagal";
                $this->keterangan = "Gagal menambahkan Artikel";
            }

            return Response::json([
                'status' => $this->status,
                'keterangan' => $this->keterangan], 200);
        });

        Response::macro('editArtikel', function ($status) {
            if ($status) {
                $this->status = "Berhasil";
                $this->keterangan = "Berhasil merubah Artikel";
            } else {
                $this->status = "Gagal";
                $this->keterangan = "Gagal merubah Artikel";
            }

            return Response::json([
                'status' => $this->status,
                'keterangan' => $this->keterangan], 200);
        });

        Response::macro('hapusArtikel', function ($status) {
            if ($status) {
                $this->status = "Berhasil";
                $this->keterangan = "Berhasil menghapus Artikel";
            } else {
                $this->status = "Gagal";
                $this->keterangan = "Gagal menghapus Artikel";
            }

            return redirect('artikel')->with($this->status, $this->keterangan);
        });

        Response::macro('uploadPhoto', function ($status, $file="") {
            if ($status) {
                $this->status = "Berhasil";
                $this->keterangan = "Berhasil upload foto ke server";
            } else {
                $this->status = "Gagal";
                $this->keterangan = "Gagal upload foto ke server";
            }

            return Response::json([
                'status' => $this->status,
                'keterangan' => $this->keterangan,
                'file'      => $file], 200);
        });
    }
}
