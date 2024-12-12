<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DokterRequest extends FormRequest
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
                    'no_hp' => 'required|min:1|max:15',
                    'id_poli' => 'required|exists:polis,id',
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'nama' => 'required|min:1|max:255',
                    'alamat' => 'required|min:1|max:255',
                    'no_hp' => 'required|min:1|max:15',
                    'id_poli' => 'required|exists:polis,id',
                ];
            default:
                break;
        }
    }
}
