<?php

namespace App\Http\Transformers;

use App\RecipeEquipment;
use League\Fractal\TransformerAbstract;

class RecipeEquipmentTransformer extends TransformerAbstract
{
    public function transform(RecipeEquipment $recipeEquipment) : array
    {
        $return = [
            'id' => $recipeEquipment->id,
            'title' => $recipeEquipment->title
        ];

        return $return;
    }
}