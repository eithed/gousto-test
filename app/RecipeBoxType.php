<?php

namespace App;

class RecipeBoxType extends Base
{
    protected $fillable = [
        'title'
    ];

    /**
     * Recipe box type can have many recipes
     */
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }
}
