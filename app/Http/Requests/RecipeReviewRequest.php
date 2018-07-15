<?php

namespace App\Http\Requests;

use App\Review;

use Illuminate\Validation\Rule;

class RecipeReviewRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'string|nullable|max:255',
            'content' => 'string|nullable|max:65535',
            'rating' => 'integer|required|min:1|max:5'
        ];
    }
}