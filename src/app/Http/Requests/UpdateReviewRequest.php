<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
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
          'contents' => ['required', 'max:255', 'string'],
          'result' => ['required', 'between:0,2', 'integer'],
          'clear_time' => ['integer', 'nullable'],
          'rating' => ['between:1,5', 'nullable'],
          'joined_at' => ['date', 'before_or_equal:' . $today, 'nullable'],
        ];
    }
}
