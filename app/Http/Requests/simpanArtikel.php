<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Response;

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
        if ($this->type == "tambah") {
        return [
                'judul'         => 'required|string|max:225|unique:artikel,judul',
                'kategori.*'      => 'required|string|exists:kategori,kode_kategori',
                'headline'      => 'required|image',
                'isi_artikel'   => 'required'
            ];
        } else if ($this->type == "edit") {
            return [
                'id_artikel'    => 'required|integer',
                'judul'         => 'required|string|max:225',
                'kategori.*'    => 'required|string|exists:kategori,kode_kategori',
                'headline'      => 'image',
                'isi_artikel'   => 'required'
            ];
        }
    }

    public function failedValidation(Validator $validator)
    {
        if ($this->type == "tambah") {
            throw new \Illuminate\Validation\ValidationException($validator, api_error('Gagal menambahkan artikel baru'));
        } else if ($this->type == "edit") {
            throw new \Illuminate\Validation\ValidationException($validator, api_error('Gagal merubah artikel baru'));
        }
    }
}
