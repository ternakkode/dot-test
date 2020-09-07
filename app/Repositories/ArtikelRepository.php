<?php namespace App\Repositories;
use App\Repositories\ArtikelInterface;
use App\Artikel;

class ArtikelRepository implements ArtikelInterface {
        
    public function tambah($data, $headline){

        $artikel = new Artikel;
        
        $artikel->judul = $data['judul'];
        $artikel->headline = $headline;
        $artikel->isi = $data['isi_artikel'];
        $artikel->save();
        $artikel->kategori()->attach($data['kategori']);

        return true;
    }

    public function edit($data, $headline=""){
        $artikel = Artikel::find($data['id_artikel']);
        
        if(!$artikel) return false;

        $artikel->judul = $data['judul'];
        if ($headline != "") $artikel->headline = $headline;
        $artikel = $data['isi_artikel'];
        $artikel->save();

        $artikel->kategori()->detach();
        $artikel->kategori()->attach($data['kategori']);

        return true;
    }

    public function hapus($id_artikel){
        $artikel = Artikel::find($id_artikel);
        if(!$artikel) return false;

        $artikel->delete();
        return true;
    }

}