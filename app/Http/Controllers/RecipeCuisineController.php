<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Transformers\RecipeCuisineTransformer;

use App\RecipeCuisine;

use App\Traits\CrudApiControllerTrait;

class RecipeCuisineController extends ApiController
{
    public $modelClass = RecipeCuisine::class;
    public $transformerClass = RecipeCuisineTransformer::class;

    // use traits to get around signature conflict issue
    use CrudApiControllerTrait {
        index as __index;
        show as __show;
    }

    public function show(RecipeCuisine $recipeCuisine, Request $request)
    {
        return $this->__show($recipeCuisine, $request);
    }
}
