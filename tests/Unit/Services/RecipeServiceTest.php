<?php

namespace Tests\Unit\Services;

use App\Recipe;
use App\RecipeBoxType;
use App\RecipeEquipment;
use App\RecipeCuisine;
use App\RecipeDietType;
use App\Slug;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Services\RecipeService;

class RecipeServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreStoresRecipe()
    {
        $recipe = factory(Recipe::class)->make([
        	'title' => 'foo'
        ]);

        $service = new RecipeService();
        $return = $service->store($recipe, request());

        $this->assertTrue($return);

        $model = Recipe::where('title', 'foo')->latest()->first();
        $this->assertNotNull($model);
    }

    public function testStoreStoresRecipeWithSlug()
    {
        $recipe = factory(Recipe::class)->make([
        	'title' => 'foo',
        ]);

        $request = request();
        $request->merge(['slug' => 'bar']);

        $service = new RecipeService();
        $return = $service->store($recipe, $request);

        $this->assertEquals('bar', $recipe->slug->title);
    }


    public function testStoreStoresRecipeWithRecipeBoxTypes()
    {
    	$recipeBoxType = factory(RecipeBoxType::class)->create();
        $recipe = factory(Recipe::class)->make([
        	'title' => 'foo',
        ]);

        $request = request();
        $request->merge(['recipe_box_type_id' => [$recipeBoxType->id]]);

        $service = new RecipeService();
        $return = $service->store($recipe, $request);

        $this->assertEquals([$recipeBoxType->id], $recipe->recipeBoxTypes->pluck('id')->toArray());
    }

    public function testStoreStoresRecipeWithRecipeEquipments()
    {
    	$recipeEquipment = factory(RecipeEquipment::class)->create();
        $recipe = factory(Recipe::class)->make([
        	'title' => 'foo',
        ]);

        $request = request();
        $request->merge(['recipe_equipment_id' => [$recipeEquipment->id]]);

        $service = new RecipeService();
        $return = $service->store($recipe, $request);

        $this->assertEquals([$recipeEquipment->id], $recipe->recipeEquipments->pluck('id')->toArray());
    }

    public function testStoreStoresRecipeWithRecipeCuisines()
    {
    	$recipeCuisine = factory(RecipeCuisine::class)->create();
        $recipe = factory(Recipe::class)->make([
        	'title' => 'foo',
        ]);

        $request = request();
        $request->merge(['recipe_cuisine_id' => [$recipeCuisine->id]]);

        $service = new RecipeService();
        $return = $service->store($recipe, $request);

        $this->assertEquals([$recipeCuisine->id], $recipe->recipeCuisines->pluck('id')->toArray());
    }

    public function testStoreStoresRecipeWithRecipeDietTypes()
    {
    	$recipeDietType = factory(RecipeDietType::class)->create();
        $recipe = factory(Recipe::class)->make([
        	'title' => 'foo',
        ]);

        $request = request();
        $request->merge(['recipe_diet_type_id' => [$recipeDietType->id]]);

        $service = new RecipeService();
        $return = $service->store($recipe, $request);

        $this->assertEquals([$recipeDietType->id], $recipe->recipeDietTypes->pluck('id')->toArray());
    }

    public function testUpdateUpdatesRecipe()
    {
        $recipe = factory(Recipe::class)->create([
        	'title' => 'foo'
        ]);

        $request = request();
        $request->merge(['title' => 'bar']);

        $service = new RecipeService();
        $return = $service->update($recipe, $request);

        $this->assertTrue($return);
		$this->assertEquals('bar', $recipe->title);
    }

    public function testUpdateUpdatesRecipeWithSlug()
    {
        $recipe = factory(Recipe::class)->create([
        	'title' => 'foo',
        ]);

        $slug = factory(Slug::class)->create([
        	'title' => 'foo',
        	'item_id' => $recipe->id,
        	'item_type' => get_class($recipe)
        ]);

        $request = request();
        $request->merge(['slug' => 'bar']);

        $service = new RecipeService();
        $return = $service->update($recipe, $request);

        $this->assertEquals('bar', $recipe->slug->title);
    }


    public function testUpdateUpdatesRecipeWithRecipeBoxTypes()
    {
    	$recipeBoxType = factory(RecipeBoxType::class)->create();
        $recipe = factory(Recipe::class)->create([
        	'title' => 'foo',
        ]);

        $request = request();
        $request->merge(['recipe_box_type_id' => [$recipeBoxType->id]]);

        $this->assertEquals([], $recipe->recipeBoxTypes->pluck('id')->toArray());

        $service = new RecipeService();
        $return = $service->update($recipe, $request);

        $this->assertEquals([$recipeBoxType->id], $recipe->recipeBoxTypes->pluck('id')->toArray());
    }

    public function testUpdateUpdatesRecipeWithRecipeEquipments()
    {
    	$recipeEquipment = factory(RecipeEquipment::class)->create();
        $recipe = factory(Recipe::class)->create([
        	'title' => 'foo',
        ]);

        $request = request();
        $request->merge(['recipe_equipment_id' => [$recipeEquipment->id]]);

        $this->assertEquals([], $recipe->recipeEquipments->pluck('id')->toArray());

        $service = new RecipeService();
        $return = $service->update($recipe, $request);

        $this->assertEquals([$recipeEquipment->id], $recipe->recipeEquipments->pluck('id')->toArray());
    }

    public function testUpdateUpdatesRecipeWithRecipeCuisines()
    {
    	$recipeCuisine = factory(RecipeCuisine::class)->create();
        $recipe = factory(Recipe::class)->create([
        	'title' => 'foo',
        ]);

        $request = request();
        $request->merge(['recipe_cuisine_id' => [$recipeCuisine->id]]);

        $this->assertEquals([], $recipe->recipeCuisines->pluck('id')->toArray());

        $service = new RecipeService();
        $return = $service->update($recipe, $request);

        $this->assertEquals([$recipeCuisine->id], $recipe->recipeCuisines->pluck('id')->toArray());
    }

    public function testUpdateUpdatesRecipeWithRecipeDietTypes()
    {
    	$recipeDietType = factory(RecipeDietType::class)->create();
        $recipe = factory(Recipe::class)->create([
        	'title' => 'foo',
        ]);

        $request = request();
        $request->merge(['recipe_diet_type_id' => [$recipeDietType->id]]);

        $this->assertEquals([], $recipe->recipeDietTypes->pluck('id')->toArray());

        $service = new RecipeService();
        $return = $service->update($recipe, $request);

        $this->assertEquals([$recipeDietType->id], $recipe->recipeDietTypes->pluck('id')->toArray());
    }

    public function testDeleteDeletesRecipe()
    {
    	$recipe = factory(Recipe::class)->create([
        	'title' => 'foo',
        ]);

        $slug = factory(Slug::class)->create([
        	'title' => 'foo',
        	'item_id' => $recipe->id,
        	'item_type' => get_class($recipe)
        ]);

        $recipeId = $recipe->id;
        $slugId = $slug->id;

        $service = new RecipeService();
        $return = $service->delete($recipe, request());

        $this->assertNull(Recipe::find($recipeId));
        $this->assertNull(Slug::find($slugId));
    }
}
