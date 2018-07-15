<?php

namespace App\Http\Transformers;

use App\RecipeDietType;
use League\Fractal\TransformerAbstract;

class RecipeDietTypeTransformer extends TransformerAbstract
{
    public function transform(RecipeDietType $recipeDietType) : array
    {
        $return = [
            'id' => $recipeDietType->id,
            'title' => $recipeDietType->title
        ];

        return $return;
    }
}