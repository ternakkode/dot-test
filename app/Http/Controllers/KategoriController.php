<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;

class KategoriController
{
    public function index(){
        $data['kategori'] = Kategori::paginate(10);
        return view('admin/kategori/index', $data);
    }

    public function tambah(){
        return view('admin/kategori/tambah');
    }

    public function edit($kode_kategori){
        try {
            $data['kategori'] = Kategori::FindOrFail($kode_kategori);
        } catch (\Exception $e) {
            return redirect('kategori');
        }
       
        return view('admin/kategori/edit', $data);
    }
}
