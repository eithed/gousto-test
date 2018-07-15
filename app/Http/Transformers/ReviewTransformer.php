<?php

namespace App\Http\Transformers;

use App\Review;
use League\Fractal\TransformerAbstract;

class ReviewTransformer extends TransformerAbstract
{
    public function transform(Review $review) : array
    {
        $return = [
            'id' => $review->id,
            'title' => $review->title,
            'content' => $review->content,
            'rating' => $review->rating,
            'created_at' => $review->created_at->format("d/m/Y H:i:s"),
            'updated_at' => $review->updated_at->format("d/m/Y H:i:s"),
        ];

        return $return;
    }
}