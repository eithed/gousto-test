<?php

namespace Tests\Unit\Services;

use App\RecipeBoxType;
use App\Exceptions\ClassTransformNotFoundException;

use App\Http\Transformers\RecipeBoxTypeTransformer;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Services\ApiService;

class ApiServiceTest extends TestCase
{
	use DatabaseTransactions;

    public function testTransformReturnsJsonForModel()
    {
        $recipeBoxType = factory(RecipeBoxType::class)->create();
        $recipeBoxTypeTransformer = new RecipeBoxTypeTransformer();

        $service = new ApiService();
        $return = $service->transform($recipeBoxType, $recipeBoxTypeTransformer)->content();

        $expected = json_encode([
        	"data" => [
    			"id" => $recipeBoxType->id,
    			"title" => $recipeBoxType->title
        	],
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $return);
    }

    public function testTransformReturnsJsonForCollection()
    {
        $recipeBoxType_1 = factory(RecipeBoxType::class)->create();
        $recipeBoxType_2 = factory(RecipeBoxType::class)->create();

        $recipeBoxTypeTransformer = new RecipeBoxTypeTransformer();

        $service = new ApiService();
        $return = $service->transform(RecipeBoxType::whereIn('id', [$recipeBoxType_1->id, $recipeBoxType_2->id])->get(), $recipeBoxTypeTransformer)->content();

        $expected = json_encode([
        	"data" => [
        		[
        			"id" => $recipeBoxType_1->id,
        			"title" => $recipeBoxType_1->title
        		],
        		[
        			"id" => $recipeBoxType_2->id,
        			"title" => $recipeBoxType_2->title
        		]
        	],
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $return);
    }

    public function testTransformReturnsJsonForPaginator()
    {
        $recipeBoxType_1 = factory(RecipeBoxType::class)->create();
        $recipeBoxType_2 = factory(RecipeBoxType::class)->create();

        $recipeBoxTypeTransformer = new RecipeBoxTypeTransformer();

        $service = new ApiService();
        $return = $service->transform(RecipeBoxType::whereIn('id', [$recipeBoxType_1->id, $recipeBoxType_2->id])->paginate(5), $recipeBoxTypeTransformer)->content();

        $expected = json_encode([
        	"data" => [
        		[
        			"id" => $recipeBoxType_1->id,
        			"title" => $recipeBoxType_1->title
        		],
        		[
        			"id" => $recipeBoxType_2->id,
        			"title" => $recipeBoxType_2->title
        		]
        	],
        	"meta" => [
        		"pagination" => [
        			"total" => 2,
        			"count" => 2,
        			"per_page" => 5,
        			"current_page" => 1,
        			"total_pages" => 1,
        			"links" => []
        		]
        	]
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $return);
    }

    public function testTransformThrowsExceptionForUndefinedClass()
    {
    	$this->expectException(ClassTransformNotFoundException::class);

    	$recipeBoxTypeTransformer = new RecipeBoxTypeTransformer();

        $service = new ApiService();
        $return = $service->transform(new \stdClass(), $recipeBoxTypeTransformer)->content();
    }
}
