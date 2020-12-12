<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'account_id' => ['required', 'string', 'max:16', 'unique:users'],
            'name' => ['required', 'string', 'max:32'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'email' => ['exists:pre_registers', 'string', 'email', 'unique:users'],
            'pre_register_id' => ['exists:pre_registers,id'],
        ];
    }
}
