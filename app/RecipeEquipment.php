<?php

namespace App;

class RecipeEquipment extends Base
{
    protected $fillable = [
        'title'
    ];

    /**
     * Recipe equipments can have many recipes
     */
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }    
}
