<?php

namespace Tests\Unit;

use App\RecipeBoxType;
use App\Recipe;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Carbon\Carbon;

class BaseTest extends TestCase
{
    use DatabaseTransactions;

    public function testClassNameIsValid()
    {
        $recipeBoxType = factory(RecipeBoxType::class)->make();
        $this->assertEquals("RecipeBoxType", $recipeBoxType->className());
        $this->assertEquals("RecipeBoxType", $recipeBoxType->className);
        $this->assertEquals("RecipeBoxType", RecipeBoxType::className());
    }

    public function testNamespaceIsValid()
    {
        // multiple word classes are hyphen separated
        $recipeBoxType = factory(RecipeBoxType::class)->make();
        $this->assertEquals("recipe-box-types", $recipeBoxType->namespace());
        $this->assertEquals("recipe-box-types", $recipeBoxType->namespace);
        $this->assertEquals("recipe-box-types", RecipeBoxType::namespace());

        $recipe = factory(Recipe::class)->make();
        $this->assertEquals("recipes", $recipe->namespace());
        $this->assertEquals("recipes", $recipe->namespace);
        $this->assertEquals("recipes", Recipe::namespace());
    }

    public function testPluralIsValid()
    {
        // multiple word classes are space separated
        $recipeBoxType = factory(RecipeBoxType::class)->make();
        $this->assertEquals("recipe box types", $recipeBoxType->plural());
        $this->assertEquals("recipe box types", $recipeBoxType->plural);
        $this->assertEquals("recipe box types", RecipeBoxType::plural());

        $recipe = factory(Recipe::class)->make();
        $this->assertEquals("recipes", $recipe->plural());
        $this->assertEquals("recipes", $recipe->plural);
        $this->assertEquals("recipes", Recipe::plural());
    }

    public function testSingularIsValid()
    {
        // multiple word classes are space separated
        $recipeBoxType = factory(RecipeBoxType::class)->make();
        $this->assertEquals("recipe box type", $recipeBoxType->singular());
        $this->assertEquals("recipe box type", $recipeBoxType->singular);
        $this->assertEquals("recipe box type", RecipeBoxType::singular());

        $recipe = factory(Recipe::class)->make();
        $this->assertEquals("recipe", $recipe->singular());
        $this->assertEquals("recipe", $recipe->singular);
        $this->assertEquals("recipe", Recipe::singular());
    }
}