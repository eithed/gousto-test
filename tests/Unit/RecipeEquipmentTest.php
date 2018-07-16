<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Recipe;
use App\RecipeEquipment;

use Carbon\Carbon;

class RecipeEquipmentTest extends TestCase
{
    use DatabaseTransactions;

    public function testRecipesRelationship()
    {
        // empty in the beginning
        $recipeEquipment = factory(RecipeEquipment::class)->create();
        $this->assertEquals(0, $recipeEquipment->recipes->count());

        // attaching models
        $recipe = factory(Recipe::class)->create();
        $recipeEquipment->recipes()->save($recipe);
        $recipeEquipment->save();
        
        // reload the relationship
        $recipeEquipment->load('recipes');

        // all the associated models are related
        $this->assertEquals(1, $recipeEquipment->recipes->count());
    }
}