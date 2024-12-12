<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasienRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'nama' => 'required|min:1|max:255',
                    'alamat' => 'required|min:1|max:255',
                    'no_ktp' => 'required|min:16|max:16|unique:pasiens,no_ktp',
                    'no_hp' => 'required|min:9|max:14',
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'nama' => 'required|min:1|max:255',
                    'alamat' => 'required|min:1|max:255',
                    'no_ktp' => 'required|min:16|max:16|unique:pasiens,no_ktp,' . request()->id,
                    'no_hp' => 'required|min:9|max:14',
                ];
            default:
                break;
        }
    }
}
