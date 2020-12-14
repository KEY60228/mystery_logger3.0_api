<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'string'],
            'account_id' => [
                'required',
                'string',
                Rule::unique('users')->ignore($this->user()),
            ],
            'profile' => [],
            'image_name' => ['file', 'mimes:jpg,jpeg,png,gif'],
        ];
    }
}
