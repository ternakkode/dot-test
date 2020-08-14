<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request, Response;
use App\Kategori;
use Validator;
use Illuminate\Validation\Rule;

class KategoriController
{
    public function tambah(Request $request){

        $validator = Validator::make($request->all(), [
            'kode_kategori'          => 'required|string|max:3|unique:kategori,kode_kategori',
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori',
        ]);
        
        if ($validator->fails()) {
            return Response::json([
                'status' => 'gagal',
                'keterangan' => $validator->errors()->all()], 200);
        }
        
        $kategori = new Kategori;
        $kategori->kode_kategori    = $request->kode_kategori;
        $kategori->nama_kategori    = $request->nama_kategori;
        $kategori->save();

        return Response::json([
            'status' => 'sukses',
            'keterangan' => 'Berhasil menambahkan Kategori'], 200);
    }

    public function edit(Request $request){
        $validator = Validator::make($request->all(), [
            'kode_kategori'          => 'required|string|max:3',
            'nama_kategori' => ['required', 'string', 'max:100', Rule::unique('kategori')->ignore($request->kode_kategori, 'kode_kategori')],
        ]);

        if ($validator->fails()) {
            return Response::json([
                'status' => 'gagal',
                'keterangan' => $validator->errors()->all()], 200);
        }

        try {
            $kategori = Kategori::find($request->kode_kategori);
        } catch (\Exception $e) {
            return Response::json([
            'status' => 'gagal',
            'keterangan' => 'Terjadi kesalahan'], 400);
        }
        
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return Response::json([
            'status' => 'sukses',
            'keterangan' => 'Berhasil menyimpan perubahan Kategori'], 200);
        
    }

    public function hapus($kode_kategori){
        
        try {
            $kategori = Kategori::find($kode_kategori);
        } catch (\Exception $e) {
            return redirect('kategori');
        }
        
        $kategori->delete();
        return redirect('kategori');
    }
}
