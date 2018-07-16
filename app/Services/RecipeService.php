<?php

namespace App\Services;

use Illuminate\Http\Request;

use App\Recipe;
use App\Slug;

class RecipeService
{
	public function store(Recipe $recipe, Request $request) : bool
	{
		$result = $recipe->save();

        if (!$result)
        	return false;

        if (!empty($request->get('slug')))
        {
            $slug = new Slug([
                'item_id' => $recipe->id,
                'item_type' => get_class($recipe),
                'title' => $request->get('slug')
            ]);

            $slug->save();
        }

        if (!empty($request->get('recipe_box_type_id')))
        {
        	$recipe->recipeBoxTypes()->sync($request->get('recipe_box_type_id'));
        }

        if (!empty($request->get('recipe_equipment_id')))
        {
        	$recipe->recipeEquipments()->sync($request->get('recipe_equipment_id'));
        }

        if (!empty($request->get('recipe_cuisine_id')))
        {
        	$recipe->recipeCuisines()->sync($request->get('recipe_cuisine_id'));
        }

        if (!empty($request->get('recipe_diet_type_id')))
        {
        	$recipe->recipeDietTypes()->sync($request->get('recipe_diet_type_id'));
        }

        return true;
	}

	public function update(Recipe $recipe, Request $request) : bool
	{
		foreach($request->all() as $attribute => $value)
			if (in_array($attribute, $recipe->getFillable()))
            	$recipe->$attribute = $value;

        $result = $recipe->save();

        if (!$result)
        	return false;

		if (!empty($request->get('slug')))
		{
            if ($recipe->slug)
            {
			    $recipe->slug->delete();
            }

	        $slug = new Slug([
	            'item_id' => $recipe->id,
	            'item_type' => get_class($recipe),
	            'title' => $request->get('slug')
	        ]);
	        $slug->save();
            $recipe->load('slug');
	    }

	    if (!empty($request->get('recipe_box_type_id')))
        {
        	$recipe->recipeBoxTypes()->sync($request->get('recipe_box_type_id'));
            $recipe->load('recipeBoxTypes');
        }

        if (!empty($request->get('recipe_equipment_id')))
        {
        	$recipe->recipeEquipments()->sync($request->get('recipe_equipment_id'));
            $recipe->load('recipeEquipments');
        }

        if (!empty($request->get('recipe_cuisine_id')))
        {
        	$recipe->recipeCuisines()->sync($request->get('recipe_cuisine_id'));
            $recipe->load('recipeCuisines');
        }

        if (!empty($request->get('recipe_diet_type_id')))
        {
        	$recipe->recipeDietTypes()->sync($request->get('recipe_diet_type_id'));
            $recipe->load('recipeDietTypes');
        }

        return true;
	}

	public function delete(Recipe $recipe, Request $request) : bool
	{
        if ($recipe->slug)
            $recipe->slug->delete();
        
        foreach($recipe->reviews as $review)
        {
            $review->delete();
        }

		return $recipe->delete();
	}
}
