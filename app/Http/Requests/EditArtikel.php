<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Response;

class EditArtikel extends FormRequest
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
            'id_artikel'    => 'required|integer',
            'judul'         => 'required|string|max:225',
            'kategori.*'    => 'required|string|exists:kategori,kode_kategori',
            'headline'      => 'image',
            'isi_artikel'   => 'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, api_error('Gagal menyimpan perubahan artikel'));
    }
}
