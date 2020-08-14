<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artikel;

class ArtikelController
{
    public function index(){
        $data['artikel'] = Artikel::paginate(8);
        return view('admin/artikel/index', $data);
    }

    public function tambah(){
        return view('admin/artikel/tambah');
    }

    public function edit($id_artikel){
        try {
            $data['artikel'] = Artikel::FindOrFail($id_artikel);
        } catch (\Exception $e) {
            return redirect('artikel');
        }
        
        return view('admin/artikel/edit', $data);

    }
}
