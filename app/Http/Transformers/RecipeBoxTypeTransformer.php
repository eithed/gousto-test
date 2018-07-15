<?php

namespace App\Http\Transformers;

use App\RecipeBoxType;
use League\Fractal\TransformerAbstract;

class RecipeBoxTypeTransformer extends TransformerAbstract
{
    public function transform(RecipeBoxType $recipeBoxType) : array
    {
        $return = [
            'id' => $recipeBoxType->id,
            'title' => $recipeBoxType->title
        ];

        return $return;
    }
}