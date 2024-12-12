<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
                    'name' => 'required|min:1|max:255',
                    'email' => 'required|email',
                    'password' => 'required|min:8|max:255',
                    'mobilenumber' => 'required|min:1|max:255',
                    'avatar' => 'nullable|min:1|max:255',
                    'role' => 'required|in:admin,owner'
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'name' => 'required|min:1|max:255',
                    'email' => 'required|email',
                    // 'password' => 'required|min:8|max:255',
                    'mobilenumber' => 'required|min:1|max:255',
                    'avatar' => 'nullable|min:1|max:255',
                    'role' => 'required|in:admin,owner'
                ];
            default:
                break;
        }
    }
}
