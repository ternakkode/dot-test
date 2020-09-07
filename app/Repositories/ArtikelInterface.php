<?php namespace App\Repositories;

interface ArtikelInterface
{
    public function tambah($data, $headline);
    public function edit($data, $headline);
    public function hapus($id_artikel);
}