<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Response;

class HapusArtikel extends FormRequest
{
    public function rules()
    {
        return [
            'id_artikel'    => 'required|integer',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, api_error('Gagal menghapus artikel'));
    }
}
