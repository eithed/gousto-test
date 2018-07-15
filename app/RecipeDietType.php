<?php

namespace App;

class RecipeDietType extends Base
{
    protected $fillable = [
        'title'
    ];

    /**
     * Recipe diet type can have many recipes
     */
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }
}
