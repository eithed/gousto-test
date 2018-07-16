<?php

namespace Tests\Unit\Traits;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Recipe;
use App\Http\Transformers\RecipeTransformer;
use App\Services\RecipeService;

use App\Traits\CrudApiControllerTrait;
use App\Exceptions\ClassNotFoundException;

class CrudApiControllerTraitTest extends TestCase
{
	use DatabaseTransactions;

    public function testIndexThrowsExceptionWhenModelClassIsNotFound()
    {
        $this->expectException(ClassNotFoundException::class);

        $mock = $this->getMockForTrait(CrudApiControllerTrait::class);
        $mock->index(request());
    }

    public function testIndexThrowsExceptionWhenTransformerClassIsNotFound()
    {
        $this->expectException(ClassNotFoundException::class);

        $mock = $this->getMockForTrait(CrudApiControllerTrait::class);
        $mock->modelClass = Recipe::class;

        $mock->index(request());
    }

    public function testIndexOutputsJson()
    {
        $recipe = factory(Recipe::class)->states('empty')->create([
        	'title' => 'foo', 
        ]);
        $mock = $this->getMockForTrait(CrudApiControllerTrait::class);
        $mock->modelClass = Recipe::class;
        $mock->transformerClass = RecipeTransformer::class;

        $return = $mock->index(request(), function($query) use ($recipe){
        	$query->where('id', $recipe->id);
        })->content();
        
        $expected = json_encode([
        	"data" => [
        		[
        			"id" => $recipe->id,
        			"created_at" => "01/01/2018 00:00:00",
        			"updated_at" => "01/01/2018 00:00:00",
        			"title" => "foo"
        		]
        	],
        	"meta" => [
        		"pagination" => [
        			"total" => 1,
        			"count" => 1,
        			"per_page" => 5,
        			"current_page" => 1,
        			"total_pages" => 1,
        			"links" => []
        		]
        	]
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $return);
    }

    public function testShowThrowsExceptionWhenModelClassIsNotFound()
    {
    	$recipe = factory(Recipe::class)->create();
        $this->expectException(ClassNotFoundException::class);

        $mock = $this->getMockForTrait(CrudApiControllerTrait::class);
        $mock->show($recipe, request());
    }

    public function testShowThrowsExceptionWhenTransformerClassIsNotFound()
    {
        $recipe = factory(Recipe::class)->create();
        $this->expectException(ClassNotFoundException::class);

        $mock = $this->getMockForTrait(CrudApiControllerTrait::class);
        $mock->modelClass = Recipe::class;

        $mock->show($recipe, request());
    }

    public function testShowOutputsJson()
    {
        $recipe = factory(Recipe::class)->states('empty')->create([
        	'title' => 'foo', 
        ]);
        $mock = $this->getMockForTrait(CrudApiControllerTrait::class);
        $mock->modelClass = Recipe::class;
        $mock->transformerClass = RecipeTransformer::class;

       	$return = $mock->show($recipe, request())->content();
       	$expected = json_encode([
        	"data" => [
    			"id" => $recipe->id,
    			"created_at" => "01/01/2018 00:00:00",
    			"updated_at" => "01/01/2018 00:00:00",
    			"title" => "foo"
    		]
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $return);
    }

    public function testStoreThrowsExceptionWhenModelClassIsNotFound()
    {
    	$recipe = factory(Recipe::class)->create();
        $this->expectException(ClassNotFoundException::class);

        $mock = $this->getMockForTrait(CrudApiControllerTrait::class);
        $mock->store(request());
    }

    public function testStoreUsingModelOutputsJson()
    {
    	$mock = $this->getMockForTrait(CrudApiControllerTrait::class);
        $mock->modelClass = Recipe::class;

        $request = request();
        $request->merge([
        	'title' => 'foo'
        ]);

        $return = $mock->store($request)->content();

        $recipe = Recipe::where('title', 'foo')->latest()->first();

        $expected = json_encode([
        	'message' => sprintf("%s %s has been successfully saved", $recipe->singular, $recipe->id)
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $return);
    }

    public function testStoreUsingServiceOutputsJson()
    {
    	$mock = $this->getMockForTrait(CrudApiControllerTrait::class);
        $mock->modelClass = Recipe::class;
        $mock->serviceClass = RecipeService::class;

        $request = request();
        $request->merge([
        	'title' => 'foo',
        ]);

        $return = $mock->store($request)->content();

        $recipe = Recipe::where('title', 'foo')->latest()->first();

        $expected = json_encode([
        	'message' => sprintf("%s %s has been successfully saved", $recipe->singular, $recipe->id)
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $return);
    }

    public function testUpdateThrowsExceptionWhenModelClassIsNotFound()
    {
    	$recipe = factory(Recipe::class)->create();
    	$this->expectException(ClassNotFoundException::class);

        $mock = $this->getMockForTrait(CrudApiControllerTrait::class);
        $mock->update($recipe, request());
    }

    public function testUpdateUsingModelOutputsJson()
    {
    	$mock = $this->getMockForTrait(CrudApiControllerTrait::class);
        $mock->modelClass = Recipe::class;

        $request = request();
        $request->merge([
        	'title' => 'foo'
        ]);

        $model = factory(Recipe::class)->create();

        $return = $mock->update($model, $request)->content();

        $recipe = Recipe::find($model->id);

        $expected = json_encode([
        	'message' => sprintf("%s %s has been successfully updated", $model->singular, $model->id)
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $return);
        $this->assertEquals('foo', $recipe->title);
    }

    public function testUpdateUsingServiceOutputsJson()
    {
    	$mock = $this->getMockForTrait(CrudApiControllerTrait::class);
        $mock->modelClass = Recipe::class;
        $mock->serviceClass = RecipeService::class;

        $request = request();
        $request->merge([
        	'title' => 'foo',
        ]);

        $model = factory(Recipe::class)->create();

        $return = $mock->update($model, $request)->content();

        $recipe = Recipe::find($model->id);

        $expected = json_encode([
        	'message' => sprintf("%s %s has been successfully updated", $model->singular, $model->id)
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $return);
        $this->assertEquals('foo', $recipe->title);
    }

    public function testDestroyThrowsExceptionWhenModelClassIsNotFound()
    {
    	$recipe = factory(Recipe::class)->create();
        $this->expectException(ClassNotFoundException::class);

        $mock = $this->getMockForTrait(CrudApiControllerTrait::class);
        $mock->destroy($recipe, request());
    }

    public function testDestroyUsingModelOutputsJson()
    {
    	$mock = $this->getMockForTrait(CrudApiControllerTrait::class);
        $mock->modelClass = Recipe::class;

        $model = factory(Recipe::class)->create();

        $return = $mock->destroy($model, request())->content();

        $recipe = Recipe::find($model->id);

        $expected = json_encode([
        	'message' => sprintf("%s %s has been successfully deleted", $model->singular, $model->id)
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $return);
        $this->assertNull($recipe);
    }

    public function testDestroyUsingServiceOutputsJson()
    {
    	$mock = $this->getMockForTrait(CrudApiControllerTrait::class);
        $mock->modelClass = Recipe::class;
        $mock->serviceClass = RecipeService::class;

        $model = factory(Recipe::class)->create();

        $return = $mock->destroy($model, request())->content();

        $recipe = Recipe::find($model->id);

        $expected = json_encode([
        	'message' => sprintf("%s %s has been successfully deleted", $model->singular, $model->id)
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $return);
        $this->assertNull($recipe);
    }
}
