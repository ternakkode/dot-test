<?php namespace App\Domain\Artikel\Repositories;

interface ArtikelInterface
{
    public function tambah($data);
    public function edit($data);
    public function hapus($id_artikel);
}