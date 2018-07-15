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
        $return = [
            'id' => $recipe->id,
            'title' => $recipe->title,
            'short_title' => $recipe->short_title,
            'marketing_description' => $recipe->marketing_description,
            'calories_kcal' => $recipe->calories_kcal,
            'protein_grams' => $recipe->protein_grams, 
            'fat_grams' => $recipe->fat_grams, 
            'carbs_grams' => $recipe->carbs_grams, 
            'bulletpoint1' => $recipe->bulletpoint1, 
            'bulletpoint2' => $recipe->bulletpoint2, 
            'bulletpoint3' => $recipe->bulletpoint3, 
            'season' => $recipe->season, 
            'base' => $recipe->base, 
            'protein_source' => $recipe->protein_source, 
            'preparation_time_minutes' => $recipe->preparation_time_minutes, 
            'shelf_life_days' => $recipe->shelf_life_days,
            'origin_country' => $recipe->origin_country,
            'in_your_box' => $recipe->in_your_box, 
            'gousto_reference' => $recipe->gousto_reference,
            'created_at' => $recipe->created_at->format("d/m/Y H:i:s"),
            'updated_at' => $recipe->updated_at->format("d/m/Y H:i:s"),
        ];

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