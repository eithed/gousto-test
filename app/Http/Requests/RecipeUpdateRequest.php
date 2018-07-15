<?php

namespace App\Http\Requests;

use App\Recipe;
use App\RecipeBoxType;
use App\RecipeDietType;
use App\RecipeEquipment;
use App\RecipeCuisine;
use App\Slug;

use Illuminate\Validation\Rule;

class RecipeUpdateRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $recipe = $this->route()->parameter('recipe');
        $recipeBoxType = new RecipeBoxType();
        $recipeDietType = new RecipeDietType();
        $recipeEquipment = new RecipeEquipment();
        $recipeCuisine = new RecipeCuisine();
        $slug = new Slug();

        return [
            'title' => 'string|nullable|sometimes|max:255',
            'slug' => [
                'string',
                'nullable',
                'sometimes',
                'max:255',
                Rule::unique($slug->getTable(), 'title')->ignore($slug->title, 'title'),
            ],
            'short_title' => 'string|max:255|nullable',
            'marketing_description' => 'string|max:65535|nullable',
            'calories_kcal' => 'integer|nullable',
            'protein_grams' => 'integer|nullable',
            'carbs_grams' => 'integer|nullable',
            'bulletpoint1' => 'string|max:255|nullable',
            'bulletpoint2' => 'string|max:255|nullable',
            'bulletpoint3' => 'string|max:255|nullable',
            'season' => 'string|max:255|nullable',
            'base' => 'string|max:255|nullable',
            'protein_source' => 'string|max:255|nullable',
            'preparation_time_minutes' => 'integer|nullable',
            'shelf_life' => 'integer|nullable',
            'origin_country' => 'string|max:255|nullable',
            'in_your_box' => 'string|max:255|nullable',
            'gousto_reference' => 'int|max:255|nullable',
            'recipe_box_type_id' => 'array',
            'recipe_box_type_id.*' => [
                'integer',
                Rule::exists($recipeBoxType->getTable(), 'id')
            ],
            'recipe_diet_type_id' => 'array',
            'recipe_diet_type_id.*' => [
                'integer',
                Rule::exists($recipeDietType->getTable(), 'id')
            ],
            'recipe_equipment_id' => 'array',
            'recipe_equipment_id.*' => [
                'integer',
                Rule::exists($recipeEquipment->getTable(), 'id')
            ],
            'recipe_cuisine_id' => 'array',
            'recipe_cuisine_id.*' => [
                'integer',
                Rule::exists($recipeCuisine->getTable(), 'id')
            ],
        ];
    }

    /**
     * Modify the input values
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (!empty($this->get('slug')))
        {
            $this->request->set('slug', str_slug($this->get('slug')));
        }
    }
}