<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Recipe;
use App\RecipeCuisine;

use Carbon\Carbon;

class RecipeCuisineTest extends TestCase
{
    use DatabaseTransactions;

    public function testRecipesRelationship()
    {
        // empty in the beginning
        $recipeCuisine = factory(RecipeCuisine::class)->create();
        $this->assertEquals(0, $recipeCuisine->recipes->count());

        // attaching models
        $recipe = factory(Recipe::class)->create();
        $recipeCuisine->recipes()->save($recipe);
        $recipeCuisine->save();
        
        // reload the relationship
        $recipeCuisine->load('recipes');

        // all the associated models are related
        $this->assertEquals(1, $recipeCuisine->recipes->count());
    }
}