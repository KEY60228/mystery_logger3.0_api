<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ReviewLikeRequest extends FormRequest
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
            'review_id' => [
                'required',
                'exists:reviews,id',
                Rule::unique('review_likes')->ignore($this->input('id'))->where(function($query) {
                    $query->where('user_id', Auth::id());
                }),
            ],
        ];
    }
}
