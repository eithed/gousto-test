<?php

namespace Tests\Unit\Services;

use App\Review;
use App\Recipe;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Services\ReviewService;

class ReviewServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreStoresReview()
    {
        $review = factory(Review::class)->make();
        $recipe = factory(Recipe::class)->create();

        $service = new ReviewService();
        $return = $service->store($review, $recipe, request());

        $this->assertTrue($return);
        $this->assertEquals(1, $recipe->reviews->count());
    }
}
