<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class FollowRequest extends FormRequest
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
            'followed_id' => [
                'required',
                'exists:users,id',
                Rule::unique('follows')->ignore($this->input('id'))->where(function($query) {
                    $query->where('following_id', Auth::id());
                }),
            ],
        ];
    }
}
