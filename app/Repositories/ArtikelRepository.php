<?php namespace App\Repositories;
use App\Repositories\ArtikelInterface;
use App\Artikel;

class ArtikelRepository implements ArtikelInterface {
        
    public function tambah($data, $headline){

        $Artikel = new Artikel;

        $artikel->judul = $data->judul;
        $artikel->headline = $headline;
        $artikel->isi = $data->isi_artikel;
        $artikel->save();
        $artikel->kategori()->attach($data->kategori);

        return true;
    }

    public function edit($data, $headline=""){
        try {
            $artikel = $this->artikel::find($data->id_artikel);
        } catch (\Exception $e) {
            return false;
        }

        $artikel->judul = $data->judul;
        if ($headline != "") $artikel->headline = $headline;
        $artikel = $data->isi_artikel;
        $artikel->save();

        $artikel->kategori()->detach();
        $artikel->kategori()->attach($data->kategori);

        return true;
    }

    public function hapus($id_artikel){
        try {
            $artikel = Artikel::findOrFail($id_artikel);
        } catch (\Exception $e) {
            return false;
        }
        
        $artikel->delete();

        return true;
    }

}