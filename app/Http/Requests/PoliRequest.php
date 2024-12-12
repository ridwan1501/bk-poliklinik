<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PoliRequest extends FormRequest
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
                    'nama_poli' => 'required|min:1|max:255',
                    'keterangan' => 'nullable|max:255',
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'nama_poli' => 'required|min:1|max:255',
                    'keterangan' => 'nullable|max:255',
                ];
            default:
                break;
        }
    }
}
