<?php

namespace App;

class Recipe extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'created_at', 'updated_at', 'title', 'short_title', 
        'marketing_description', 'calories_kcal', 'protein_grams', 'fat_grams', 'carbs_grams', 
        'bulletpoint1', 'bulletpoint2', 'bulletpoint3', 'season', 'base', 
        'protein_source', 'preparation_time_minutes', 'shelf_life_days',
        'origin_country', 'in_your_box', 'gousto_reference'
    ];

    /**
     * Recipe can have many recipe box types
     */
    public function recipeBoxTypes()
    {
        return $this->belongsToMany(RecipeBoxType::class);
    }

    /**
     * Recipe can have many recipe equipments
     */
    public function recipeEquipments()
    {
        return $this->belongsToMany(RecipeEquipment::class);
    }

    /**
     * Recipe can have many cuisines
     */
    public function recipeCuisines()
    {
        return $this->belongsToMany(RecipeCuisine::class);
    }

    /**
     * Recipe can have many recipe diet types
     */
    public function recipeDietTypes()
    {
        return $this->belongsToMany(RecipeDietType::class);
    }

    /**
     * Recipe can have slug
     */
    public function slug()
    {
        return $this->morphOne(Slug::class, 'item');
    }

    /**
     * Recipe can have multiple reviews
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'item');
    }
}
