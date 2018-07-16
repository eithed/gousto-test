<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Recipe;
use App\RecipeDietType;

use Carbon\Carbon;

class RecipeDietTypeTest extends TestCase
{
    use DatabaseTransactions;

    public function testRecipesRelationship()
    {
        // empty in the beginning
        $recipeDietType = factory(RecipeDietType::class)->create();
        $this->assertEquals(0, $recipeDietType->recipes->count());

        // attaching models
        $recipe = factory(Recipe::class)->create();
        $recipeDietType->recipes()->save($recipe);
        $recipeDietType->save();
        
        // reload the relationship
        $recipeDietType->load('recipes');

        // all the associated models are related
        $this->assertEquals(1, $recipeDietType->recipes->count());
    }
}