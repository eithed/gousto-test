<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Recipe;
use App\RecipeBoxType;
use App\RecipeEquipment;
use App\RecipeCuisine;
use App\RecipeDietType;
use App\Slug;
use App\Review;

use Carbon\Carbon;

class RecipeTest extends TestCase
{
    use DatabaseTransactions;

    public function testRecipeBoxTypesRelationship()
    {
        // empty in the beginning
        $recipe = factory(Recipe::class)->create();
        $this->assertEquals(0, $recipe->recipeBoxTypes->count());

        // attaching models
        $recipeBoxType = factory(RecipeBoxType::class)->create();
        $recipe->recipeBoxTypes()->save($recipeBoxType);
        $recipe->save();
        
        // reload the relationship
        $recipe->load('recipeBoxTypes');

        // all the associated models are related
        $this->assertEquals(1, $recipe->recipeBoxTypes->count());
    }

    public function testRecipeEquipmentsRelationship()
    {
        // empty in the beginning
        $recipe = factory(Recipe::class)->create();
        $this->assertEquals(0, $recipe->recipeEquipments->count());

        // attaching models
        $recipeEquipment = factory(RecipeEquipment::class)->create();
        $recipe->recipeEquipments()->save($recipeEquipment);
        $recipe->save();
        
        // reload the relationship
        $recipe->load('recipeEquipments');

        // all the associated models are related
        $this->assertEquals(1, $recipe->recipeEquipments->count());
    }

    public function testRecipeCuisinesRelationship()
    {
        // empty in the beginning
        $recipe = factory(Recipe::class)->create();
        $this->assertEquals(0, $recipe->recipeCuisines->count());

        // attaching models
        $recipeCuisine = factory(RecipeCuisine::class)->create();
        $recipe->recipeCuisines()->save($recipeCuisine);
        $recipe->save();
        
        // reload the relationship
        $recipe->load('recipeCuisines');

        // all the associated models are related
        $this->assertEquals(1, $recipe->recipeCuisines->count());
    }

    public function testRecipeDietTypesRelationship()
    {
        // empty in the beginning
        $recipe = factory(Recipe::class)->create();
        $this->assertEquals(0, $recipe->recipeDietTypes->count());

        // attaching models
        $recipeDietType = factory(RecipeDietType::class)->create();
        $recipe->recipeDietTypes()->save($recipeDietType);
        $recipe->save();
        
        // reload the relationship
        $recipe->load('recipeDietTypes');

        // all the associated models are related
        $this->assertEquals(1, $recipe->recipeDietTypes->count());
    }

    public function testSlugRelationship()
    {
        // empty in the beginning
        $recipe = factory(Recipe::class)->create();
        $this->assertNull($recipe->slug);

        // attaching models
        $slug = factory(Slug::class)->create([
        	'item_type' => get_class($recipe),
        	'item_id' => $recipe->id
        ]);
        $slug->save();
        
        // reload the relationship
        $recipe->load('slug');

        // all the associated models are related
        $this->assertEquals($slug->id, $recipe->slug->id);
    }

    public function testReviewsRelationship()
    {
        // empty in the beginning
        $recipe = factory(Recipe::class)->create();
        $this->assertEquals(0, $recipe->reviews->count());

        // attaching models
        $review = factory(Review::class)->create([
        	'item_type' => get_class($recipe),
        	'item_id' => $recipe->id
        ]);
        $recipe->reviews()->save($review);
        $recipe->save();
        
        // reload the relationship
        $recipe->load('reviews');

        // all the associated models are related
        $this->assertEquals(1, $recipe->reviews->count());
    }
}