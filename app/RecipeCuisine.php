<?php

namespace App;

class RecipeCuisine extends Base
{
    protected $fillable = [
        'title'
    ];

    /**
     * Recipe cuisines can have many recipes
     */
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }
}
