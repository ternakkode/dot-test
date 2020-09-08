<?php
namespace App\Domain\Artikel\Application;

use App\Domain\Artikel\Repositories\ArtikelRepository;
use App\Artikel;

class simpanArtikelApplication
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
        $data['headline'] = $this->uploadGambar($data['headline']);

        $this->artikelRepository->tambah($data);
        $this->artikelRepository->attachKategori($data['kategori']);
    }

    public function editArtikel($data)
    {
        $data['headline'] = isset($data['headline']) ? $this->uploadGambar($data['headline']) : null;
        
        $this->artikelRepository->edit($data);
        $this->artikelRepository->detachKategori();
        $this->artikelRepository->attachKategori($data['kategori']);
    }

    public function hapusArtikel($id_artikel)
    {
        $this->artikelRepository->hapus($id_artikel);
    }

    public function uploadGambar($file)
    {
        pindahFile($file, $this->directory);

        return $this->directory.$file->getClientOriginalName();
    }
}
