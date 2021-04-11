<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'keywords' => [],
            'organizer' => ['integer'],
            'category' => ['integer', 'between:1,5'],
            'venue' => ['integer'],
            'pref' => ['integer', 'between:1,47'],
            'ranking' => ['integer', 'between:1,5']
        ];
    }
}
