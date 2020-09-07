<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class simpanArtikel extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'kategori' => explode(" ", $this->kategori),
        ]);
    }
    
    public function rules()
    {
        // validasi apakah proses tambah atau edit
        // if($this->type == "tambah") {
            return [
                'judul'         => 'required|string|max:225|unique:artikel,judul',
                'kategori.*'      => 'required|string|exists:kategori,kode_kategori',
                'headline'      => 'required|image',
                'isi_artikel'   => 'required'
            ];
        // } else if ($this->type == "edit") { 
        //     return [
        //         'id_artikel'    => 'required|integer',
        //         'judul'         => 'required|string|max:225',
        //         'kategori.*'    => 'required|string|exists:kategori,kode_kategori',
        //         'headline'      => 'image',
        //         'isi_artikel'   => 'required'
        //     ];
        // }
    }
    
    public function messages(){
        return [
            'judul.required' => 'Pastikan anda telah mengisi semua form inputan!',
            'kategori.*.exists' => 'Pastikan Kategori yang anda masukkan ada dalam data.',
            'unique' => 'Pastikan judul yang anda masukkan belum pernah dipakai sebelumnya.',
            'image' => 'Pastikan file yang anda masukkan berformat gambar.',
            'max'   => 'Pastikan panjang teks anda tidak melebihi batas.'
        ];
    }
}
