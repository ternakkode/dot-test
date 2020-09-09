<?php namespace App\Domain\Artikel\Repositories;
use App\Domain\Artikel\Repositories\ArtikelInterface;
use App\Artikel;


class ArtikelRepository implements ArtikelInterface {

    public $model;

    public function __construct(Artikel $model){
        $this->model = $model;
    }

    public function store($data){
        $this->model->judul = $data->judul ?? $this->model->judul;
        $this->model->headline = $data->headline ?? $this->model->headline;
        $this->model->isi = $data->isi_artikel ?? $this->model->isi_artikel;
        $this->model->save();
    }

    public function cari($id_artikel){
        return $this->model->find($id_artikel);
    }

    public function hapus($id_artikel){
        return $this->model->delete();
    }

    public function detachKategori(){
        return $this->model->kategori()->detach();
    }

    public function attachKategori($kategori){
        return $this->model->kategori()->attach($kategori);
    }

}