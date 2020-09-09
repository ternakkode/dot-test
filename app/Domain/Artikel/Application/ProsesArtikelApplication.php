<?php
namespace App\Domain\Artikel\Application;

use App\Domain\Artikel\Repositories\ArtikelRepository;
use App\Artikel;

class ProsesArtikelApplication
{
    private $artikelRepository;
    private $directory;

    public function __construct(
        ArtikelRepository $artikelRepository
    ) {
        $this->artikelRepository = $artikelRepository;
        $this->directory = 'img/artikel/'.date("Y/m/d").'/';
    }

    public function tambahArtikel($data)
    {
        $data->headline = $this->uploadGambar($data->headline);

        $this->artikelRepository->store($data);
        $this->artikelRepository->attachKategori($data->kategori);
    }

    public function editArtikel($data)
    {
        $data->headline = isset($data->headline) ? $this->uploadGambar($data->headline) : null;
        
        $this->cari($data->id_artikel);

        $this->artikelRepository->store($data);
        $this->artikelRepository->detachKategori();
        $this->artikelRepository->attachKategori($data->kategori);
    }

    public function hapusArtikel($data)
    {
        $this->cari($data->id_artikel);

        $this->artikelRepository->hapus($data->id_artikel);
        $this->artikelRepository->detachKategori();
    }

    public function cari($id_artikel){
        $this->artikelRepository = new ArtikelRepository(Artikel::find($id_artikel));
    }

    public function uploadGambar($file)
    {
        pindahFile($file, $this->directory);

        return $this->directory.$file->getClientOriginalName();
    }
}
