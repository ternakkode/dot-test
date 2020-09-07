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
        $this->ArtikelRepository = $ArtikelRepository;
    }

    public function tambah(simpanArtikel $request){
        // validasi inputan
        $data = $request->validated();
        // upload foto headline ke server dan rename
        $headline = $this->prosesUpload($data['headline'],'directory');

        // proses ke database
        $this->ArtikelRepository->tambah($data, $headline);

        // berikan response
        return Response::json([
            'status' => 'sukses',
            'keterangan' => 'Berhasil menambahkan Artikel'], 200);
    }

    public function edit(simpanArtikel $request){
        // validasi inputan
        $data = $request->validated();        

        // upload foto headline ke server dan rename
        if ($request->hasFile('headline')) {
            $headline = $this->prosesUpload($request->file('headline'),'directory');
        }
        
        // proses ke database
        $this->ArtikelRepository->edit($data, $headline);

        // berikan response
        return Response::json([
            'status' => 'sukses',
            'keterangan' => 'Berhasil merubah isi Artikel'], 200);
    }

    public function hapus($id_artikel){
        // proses ke database
        $this->ArtikelRepository->hapus($id_artikel);

        return redirect('artikel');
    }

    public function uploadPhoto(Request $request){
        if($request->hasFile('upload')) {
            $file = $this->prosesUpload($request->file('upload'), 'url');

            return Response::json([
                'status' => 'sukses', // sukses / gagal
                'keterangan' => 'berhasil upload foto ke server',
                'url' => $file], 200);
        }
    }

    private function prosesUpload($file, $output){
        $directory      = 'img/artikel/'.date("Y/m/d").'/';
        $file->move($directory, $file->getClientOriginalName());

        if($output == 'directory') {
            return $directory.$file->getClientOriginalName();
        } else if($output == 'url') {
            return url($directory.$file->getClientOriginalName());
        }
    }
}
