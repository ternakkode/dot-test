<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request, Response;
use App\Artikel;
use Validator;

class ArtikelController extends Controller
{
    public function tambah(Request $request){

        $input = [
            'judul'         => $request->judul,
            'kategori'      => explode(" ", $request->kategori),
            'headline'      => $request->headline,
            'isi_artikel'   => $request->isi
        ];

        $validator = Validator::make($input, [
            'judul'         => 'required|string|max:225|unique:artikel,judul',
            'kategori.*'      => 'required|string|exists:kategori,kode_kategori',
            'headline'      => 'required|image',
            'isi_artikel'   => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json([
                'status' => 'gagal',
                'keterangan' => $validator->errors()->all()], 200);
        }
        
        $headline = $this->prosesUpload($request->file('headline'),'directory');

        $artikel = new Artikel;
        $artikel->judul = $input['judul'];
        $artikel->headline = $headline;
        $artikel->isi = $input['isi_artikel'];
        $artikel->save();
        $artikel->kategori()->attach($input['kategori']);

        return Response::json([
            'status' => 'sukses',
            'keterangan' => 'Berhasil menambahkan Artikel'], 200);
    }

    public function edit(Request $request){

        $input = [
            'id_artikel'    => $request->id_artikel,
            'judul'         => $request->judul,
            'kategori'      => explode(" ", $request->kategori),
            'isi_artikel'   => $request->isi
        ];
        
        if ($request->hasFile('headline')) {
            $input['headline'] = $request->headline;
        }

        $validator = Validator::make($input, [
            'id_artikel'    => 'required|integer',
            'judul'         => 'required|string|max:225',
            'kategori.*'    => 'required|string|exists:kategori,kode_kategori',
            'headline'      => 'image',
            'isi_artikel'   => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json([
                'status' => 'gagal',
                'keterangan' => $validator->errors()->all()], 200);
        }
        
        try {
            $artikel = Artikel::find($input['id_artikel']);
        } catch (\Exception $e) {
            return Response::json([
            'status' => 'gagal',
            'keterangan' => 'Terjadi kesalahan'], 400);
        }

        $artikel->judul = $input['judul'];
        if ($request->hasFile('headline')) {
            $headline = $this->prosesUpload($request->file('headline'),'directory');
            $artikel->headline = $headline;
        }
        $artikel->isi = $input['isi_artikel'];
        $artikel->save();

        $artikel->kategori()->detach();
        $artikel->kategori()->attach($input['kategori']);

        return Response::json([
            'status' => 'sukses',
            'keterangan' => 'Berhasil menambahkan Artikel'], 200);
    }

    public function hapus($id_artikel){
        try {
            $artikel = Artikel::find($id_artikel);
        } catch (\Exception $e) {
            return redirect('kategori');
        }
        
        $artikel->delete();

        return redirect('kategori');
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
