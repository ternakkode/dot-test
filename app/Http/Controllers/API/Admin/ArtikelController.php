<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\simpanArtikel;
use App\Repositories\ArtikelRepository;
use Illuminate\Http\Request, Response;
use App\Artikel;

class ArtikelController{

    private $ArtikelRepository;

    public function __construct(ArtikelRepository $ArtikelRepository)
    {
        // inisiasi repository
        $this->ArtikelRepository = $ArtikelRepository;
    }

    public function tambah(simpanArtikel $request){
        // validasi inputan
        $data = $request->validated();

        // upload foto headline ke server dan rename
        $headline = $this->prosesUpload($data['headline'],'directory');

        // proses ke database
        if(!$this->ArtikelRepository->tambah($data, $headline)) return Response::tambahArtikel(false);

        // berikan response
        return Response::tambahArtikel(true);
    }

    public function edit(simpanArtikel $request){
        // validasi inputan
        $data = $request->validated();        

        // upload foto headline ke server dan rename
        if ($request->hasFile('headline')) {
            $headline = $this->prosesUpload($request->file('headline'),'directory');
        }
        
        // proses ke database
        if(!$this->ArtikelRepository->edit($data, $headline)) return Response::editArtikel(false);

        // berikan response
        return Response::editArtikel(true);
    }

    public function hapus($id_artikel){
        // proses ke database
        if(!$this->ArtikelRepository->hapus($id_artikel)) return Response::hapusArtikel(false);

        // berikan response
        return Response::hapusArtikel(true);
    }

    public function uploadPhoto(Request $request){
        // validasi apakah ada inputan file
        if($request->hasFile('upload')) {
            // proses memindahkan file
            $file = $this->prosesUpload($request->file('upload'), 'url');
            // validasi inputan file
            if($file) return Response::uploadPhoto(false);

            // berikan response
            return Response::uploadPhoto(true, $file);

            
        }
    }

    private function prosesUpload($file, $output){
        // buat folder berdasarkan default directory & date
        $directory      = 'img/artikel/'.date("Y/m/d").'/';
        // pindahkan file ke folder yang sudah disiapkan
        $file->move($directory, $file->getClientOriginalName());

        // seleksi kondisi untuk response
        if($output == 'directory') {
            return $directory.$file->getClientOriginalName();
        } else if($output == 'url') {
            return url($directory.$file->getClientOriginalName());
        }
    }
}
