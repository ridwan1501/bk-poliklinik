<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JadwalPeriksaRequest extends FormRequest
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
                    'id_dokter' => 'nullable|exists:dokters,id',
                    'hari' => 'required|min:1|max:255',
                    'jam_mulai' => 'required|date_format:H:i',
                    'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
                    'status' => 'numeric',
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'id_dokter' => 'nullable|exists:dokters,id',
                    // 'hari' => 'required|min:1|max:255',
                    // 'jam_mulai' => 'required|date_format:H:i',
                    // 'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
                    'status' => 'numeric',
                ];
            default:
                break;
        }
    }
}
