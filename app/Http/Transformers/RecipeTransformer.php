<?php

namespace App\Http\Transformers;

use App\Recipe;
use League\Fractal\TransformerAbstract;

use App\Services\ApiService;

class RecipeTransformer extends TransformerAbstract
{
    public function __construct()
    {
        $this->apiService = new ApiService();
    }

    public function transform(Recipe $recipe) : array
    {
        $return = [];

        foreach($recipe->getFillable() as $key) {
            if (!is_null($recipe->{$key})) {
                $return[$key] = $recipe->{$key};
            }
        }

        $return['created_at'] = $recipe->created_at->format("d/m/Y H:i:s");
        $return['updated_at'] = $recipe->updated_at->format("d/m/Y H:i:s");

        if ($recipe->recipeBoxTypes->count() > 0)
        {
            $return['recipe_box_types'] = $this->apiService->transform($recipe->recipeBoxTypes, new RecipeBoxTypeTransformer())->original['data'];
        }

        if ($recipe->recipeDietTypes->count() > 0)
        {
            $return['recipe_diet_types'] = $this->apiService->transform($recipe->recipeDietTypes, new RecipeDietTypeTransformer())->original['data'];
        }

        if ($recipe->recipeEquipments->count() > 0)
        {
            $return['recipe_equipments'] = $this->apiService->transform($recipe->recipeEquipments, new RecipeEquipmentTransformer())->original['data'];
        }

        if ($recipe->recipeCuisines->count() > 0)
        {
            $return['recipe_cuisines'] = $this->apiService->transform($recipe->recipeCuisines, new RecipeCuisineTransformer())->original['data'];
        }

        if ($recipe->slug)
        {
            $return['slug'] = $recipe->slug->title;
        }

        if ($recipe->reviews->count() > 0)
        {
            $return['reviews'] = $this->apiService->transform($recipe->reviews, new ReviewTransformer())->original['data'];
        }

        return $return;
    }
}