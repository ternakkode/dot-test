<?php namespace App\Domain\Artikel\Repositories;
use App\Repositories\ArtikelInterface;
use App\Artikel;


class ArtikelRepository implements ArtikelInterface {

    public $model;

    public function __construct(Artikel $model){
        $this->$model = $model;
    }

    public function tambah($data, $headline){
        $this->model = new Artikel;
        $this->model->judul = $data['judul'];
        $this->model->headline = $headline;
        $this->model->isi = $data['isi_artikel'];
        $this->model->save();
    }

    public function edit($data, $headline=""){
        $this->model = Artikel::find($data['id_artikel']);
        $this->model->judul = $data['judul'];
        $this->model = $data['isi_artikel'];
        $this->model->save();
    }

    public function cari($id_artikel){
        return $this->model->find($id_artikel);
    }

    public function hapus($id_artikel){
        $this->model = Artikel::find($id_artikel);
        return $this->model->delete();
    }

    public function detachKategori(){
        return $this->model->kategori()->detach();
    }

    public function attachKategori($kategori){
        return $this->model->kategori()->attach($kategori);
    }

}