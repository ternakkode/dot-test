<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request, Response;
use Validator;
use App\Artikel;
use App\Kategori;

class ArtikelController
{
    public function semua(Request $request){

        $validator = Validator::make($request->all(), [
            'kategori'         => 'string|max:3|exists:kategori,kode_kategori',
            'judul'            => 'string|max:255|',
        ]);

        if ($validator->fails()) {
            return Response::json([
                'status' => 'gagal',
                'keterangan' => $validator->errors()->all()], 400);
        }

        $kategori = $request->get('kategori');
        $judul = $request->get('judul');

        if($kategori){
            $data = Artikel::with(['kategori' => function($query) use ($kategori, $judul) {$query->where('kategori.kode_kategori', $kategori);}])->where('judul', 'like', '%'.$judul. '%')->get();
        }else{
            $data = Artikel::with('kategori')->where('judul', 'like', '%'.$judul. '%')->get();
        }
        
        $data->makeHidden(['isi'])->append('potongan_isi')->toArray();
        
        return Response::json([
            'status' => 'sukses',
            'keterangan' => 'Berhasil mengambil data Artikel',
            'data'       => $data], 200);
    }

    public function detail($id_artikel){
        try {
            $artikel = Artikel::FindOrFail($id_artikel);

            return Response::json([
                'status' => 'sukses',
                'keterangan' => 'Berhasil mengambil data Artikel',
                'data'       => $artikel], 200);
        } catch (\Exception $e) {
            return Response::json([
                'status' => 'gagal',
                'keterangan' => 'Terjadi kesalahan ketika mengambil data.'
            ], 404);
        }
    }
}
