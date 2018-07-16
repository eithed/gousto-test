<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Recipe;
use App\Slug;

use Carbon\Carbon;

class SlugTest extends TestCase
{
    use DatabaseTransactions;

    public function testItemRelationship()
    {
    	$item = factory(Recipe::class)->create();

        // empty in the beginning
        $review = factory(Slug::class)->create([
        	'item_type' => get_class($item),
        	'item_id' => $item->id
        ]);
        $this->assertEquals($item->id, $review->item->id);
    }
}