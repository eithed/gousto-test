<?php

namespace Tests\Integration\Http\Controllers;

use App\Recipe;
use App\RecipeCuisine;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Carbon\Carbon;

class RecipeControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndexReturnsJson()
    {
        $recipeCuisine = factory(RecipeCuisine::class)->create();

        $recipe = factory(Recipe::class)->states('empty')->create([
            'title' => 'foo', 
        ]);

        $recipeCuisine->recipes()->save($recipe);
        $recipeCuisine->save();

    	$response = $this->json('GET', sprintf('/recipes/?recipe_cuisine_id=%s', $recipeCuisine->id));

        $expected = [
            "data" => [
                [
                    "id" => $recipe->id,
                    "created_at" => "01/01/2018 00:00:00",
                    "updated_at" => "01/01/2018 00:00:00",
                    "title" => "foo",
                    "recipe_cuisines" => [
                        [
                            "id" => $recipeCuisine->id,
                            "title" => $recipeCuisine->title
                        ]
                    ]
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
        ];
        
        $response->assertStatus(200)
            ->assertJson($expected);
    }

    public function testShowReturnsJson()
    {
        $recipe = factory(Recipe::class)->states('empty')->create([
            'title' => 'foo', 
        ]);

        $response = $this->json('GET', sprintf('/recipes/%s', $recipe->id));

        $expected = [
            "data" => [
                "id" => $recipe->id,
                "created_at" => "01/01/2018 00:00:00",
                "updated_at" => "01/01/2018 00:00:00",
                "title" => "foo",
            ],
        ];
        
        $response->assertStatus(200)
            ->assertJson($expected);
    }

    public function testStoreFailsOnValidation()
    {
        $response = $this->json('POST', '/recipes/', [
        ]);

        $expected = [
            "message" => "The given data was invalid."
        ];

        $response->assertStatus(422)
            ->assertJson($expected);
    }

    public function testStoreReturnsJson()
    {
        $response = $this->json('POST', '/recipes/', [
            'title' => 'foo',
            'slug' => 'bar'
        ]);

        $recipe = Recipe::latest()->first();

        $expected = [
            "message" => sprintf("%s %s has been successfully saved", $recipe->singular, $recipe->id)
        ];

        $response->assertStatus(200)
            ->assertJson($expected);
    }

    public function testUpdateFailsOnValidation()
    {
        $recipe = factory(Recipe::class)->states('empty')->create([
            'title' => 'foo', 
        ]);

        $response = $this->json('PUT', sprintf('/recipes/%s', $recipe->id), [
            'recipe_box_type_id' => 'foo',
        ]);

        $expected = [
            "message" => "The given data was invalid."
        ];

        $response->assertStatus(422)
            ->assertJson($expected);
    }

    public function testUpdateReturnsJson()
    {
        $recipe = factory(Recipe::class)->states('empty')->create([
            'title' => 'foo', 
        ]);

        $response = $this->json('PUT', sprintf('/recipes/%s', $recipe->id), [
            'title' => 'bar',
        ]);

        $expected = [
            "message" => sprintf("%s %s has been successfully updated", $recipe->singular, $recipe->id)
        ];

        $response->assertStatus(200)
            ->assertJson($expected);

        $recipe->refresh();
        $this->assertEquals('bar', $recipe->title);
    }

    public function testDeleteReturnsJson()
    {
        $recipe = factory(Recipe::class)->states('empty')->create([
            'title' => 'foo', 
        ]);

        $response = $this->json('DELETE', sprintf('/recipes/%s', $recipe->id));

        $expected = [
            "message" => sprintf("%s %s has been successfully deleted", $recipe->singular, $recipe->id)
        ];

        $recipe = Recipe::find($recipe->id);

        $response->assertStatus(200)
            ->assertJson($expected);

        $this->assertNull($recipe);
    }

    public function testReviewFailsOnValidation()
    {
        $recipe = factory(Recipe::class)->states('empty')->create([
            'title' => 'foo', 
        ]);
        
        $response = $this->json('POST', sprintf('/recipes/%s/review/', $recipe->id), [
        ]);

        $expected = [
            "message" => "The given data was invalid."
        ];

        $response->assertStatus(422)
            ->assertJson($expected);
    }

    public function testReviewReturnsJson()
    {
        $recipe = factory(Recipe::class)->states('empty')->create([
            'title' => 'foo', 
        ]);

        $response = $this->json('POST', sprintf('/recipes/%s/review', $recipe->id), [
            'rating' => 4
        ]);

        $expected = [
            "message" => sprintf("%s %s has been successfully reviewed", $recipe->singular, $recipe->id)
        ];

        $response->assertStatus(200)
            ->assertJson($expected);

        $this->assertEquals([4], $recipe->reviews->pluck('rating')->toArray());
    }
}