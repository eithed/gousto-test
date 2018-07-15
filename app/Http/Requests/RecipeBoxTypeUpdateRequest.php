<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class RecipeBoxTypeUpdateRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'string|nullable|sometimes|max:255',
        ];
    }
}