<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request, Response;
use App\Kategori;

class KategoriController
{
    public function semua(){

        $data = Kategori::all();
        
        return Response::json([
            'status' => 'sukses',
            'keterangan' => 'Berhasil mengambil data Kategori',
            'data'       => $data], 200);
    }
}
