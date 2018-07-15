<?php

namespace App\Services;

use Illuminate\Http\Request;

use App\Review;
use App\Base;

class ReviewService
{
	public function store(Review $review, Base $model, Request $request) : bool
	{
        $review->item_type = get_class($model);
        $review->item_id = $model->id;

		return $review->save();
	}
}
