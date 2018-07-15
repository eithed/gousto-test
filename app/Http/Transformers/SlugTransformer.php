<?php

namespace App\Http\Transformers;

use App\Slug;
use League\Fractal\TransformerAbstract;

class SlugTransformer extends TransformerAbstract
{
    public function transform(Slug $slug) : array
    {
        $return = [
            'id' => $slug->id,
            'title' => $slug->title
        ];

        return $return;
    }
}