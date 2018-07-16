<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Recipe;
use App\RecipeBoxType;

use Carbon\Carbon;

class RecipeBoxTypeTest extends TestCase
{
    use DatabaseTransactions;

    public function testRecipesRelationship()
    {
        // empty in the beginning
        $recipeBoxType = factory(RecipeBoxType::class)->create();
        $this->assertEquals(0, $recipeBoxType->recipes->count());

        // attaching models
        $recipe = factory(Recipe::class)->create();
        $recipeBoxType->recipes()->save($recipe);
        $recipeBoxType->save();
        
        // reload the relationship
        $recipeBoxType->load('recipes');

        // all the associated models are related
        $this->assertEquals(1, $recipeBoxType->recipes->count());
    }
}