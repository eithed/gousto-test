<?php

namespace App\Http\Transformers;

use App\RecipeCuisine;
use League\Fractal\TransformerAbstract;

class RecipeCuisineTransformer extends TransformerAbstract
{
    public function transform(RecipeCuisine $recipeCuisine) : array
    {
        $return = [
            'id' => $recipeCuisine->id,
            'title' => $recipeCuisine->title
        ];

        return $return;
    }
}