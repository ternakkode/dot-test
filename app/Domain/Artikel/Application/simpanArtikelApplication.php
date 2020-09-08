<?php
namespace App\Domain\Artikel\Application;

use App\Domain\Artikel\Repositories\ArtikelRepository;

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
        $headline = $this->uploadGambar($data['headline']);

        $this->artikelRepository->tambah($data, $headline);
        $this->artikelRepository->attachKategori($data['kategori']);
    }

    public function editArtikel($data)
    {
        $headline = $this->uploadGambar($data['headline']);

        $this->cariArtikel($data['id_artikel']);
        $this->artikelRepository->tambah($data, $headline);
        $this->artikelRepository->detachKategori();
        $this->artikelRepository->attachKategori($data['kategori']);
    }

    public function hapusArtikel($id_artikel)
    {
        $this->cariArtikel($id_artikel);
        $this->artikelRepository->hapus();
    }

    public function cariArtikel($id_artikel)
    {
        $artikel = Artikel::find($id_artikel);
        if (!$artikel) {
            throw (new Exception('Artikel tidak ditemukan'));
        }

        $this->artikelRepository = new ArtikelRepository($artikel);
    }

    public function uploadGambar($file)
    {
        pindahFile($file, $this->directory);

        return $this->directory.$file->getClientOriginalName();
    }
}
