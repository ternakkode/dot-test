<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Artikel;

class ArtikelTest extends TestCase
{
    use WithFaker;

    public function test_berhasil_tambah_artikel()
    {
        Storage::fake('headline');

        $file = UploadedFile::fake()->image('headline.jpg');

        $response = $this->post(route('tambah-artikel'), [
            'judul'         => $this->faker->text(20),
            'kategori'      => 'KTR',
            'isi_artikel'   => $this->faker->text(200),
            'headline'      => $file

        ]);
       
        $response->assertStatus(200);
    }

    public function test_berhasil_edit_artikel()
    {
        $artikel = Artikel::first();
        Storage::fake('headline');

        $file = UploadedFile::fake()->image('headline.jpg');

        $response = $this->post(route('edit-artikel'), [
            'id_artikel'    => $artikel->id_artikel,
            'judul'         => $this->faker->text(20),
            'kategori'      => 'KTR',
            'isi_artikel'   => $this->faker->text(200),
            'headline'      => $file

        ]);
        
        $response->dump();
        $response->assertStatus(200);
    }

    public function test_berhasil_hapus_artikel()
    {
        $artikel = Artikel::first();

        $response = $this->post(route('hapus-artikel'), [
            'id_artikel'    => $artikel->id_artikel

        ]);
        
        $response->assertStatus(200);
    }
}
