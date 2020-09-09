<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Response;

class TambahArtikel extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'kategori' => explode(" ", $this->kategori),
        ]);
    }
    
    public function rules()
    {
        return [
            'judul'         => 'required|string|max:225|unique:artikel,judul',
            'kategori.*'      => 'required|string|exists:kategori,kode_kategori',
            'headline'      => 'required|image',
            'isi_artikel'   => 'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(api_error('Gagal menambahkan artikel baru'));
    }
}
