<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class PostReviewRequest extends FormRequest
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
        $today = date('Y-m-d');

        return [
            'product_id' => [
                'required',
                'integer',
                'exists:App\Models\Product,id',
                Rule::unique('reviews')->ignore($this->input('id'))->where(function($query) {
                    $query->where('user_id', Auth::id())->whereNull('deleted_at');
                }),
            ],
            'contents' => ['max:255'],
            'spoil' => ['required', 'boolean'],
            'result' => ['required', 'between:0,2', 'integer'],
            'rating' => ['required', 'between:0,5'],
            'joined_at' => ['date', 'before_or_equal:' . $today, 'nullable'],
        ];
    }
}
