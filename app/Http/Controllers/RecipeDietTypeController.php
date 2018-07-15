<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Transformers\RecipeDietTypeTransformer;

use App\RecipeDietType;

use App\Traits\CrudApiControllerTrait;

class RecipeDietTypeController extends ApiController
{
    static public $modelClass = RecipeDietType::class;
    static public $transformerClass = RecipeDietTypeTransformer::class;

    // use traits to get around signature conflict issue
    use CrudApiControllerTrait {
        index as __index;
        show as __show;
    }

    public function show(RecipeDietType $recipeDietType, Request $request)
    {
    	return $this->__show($recipeDietType, $request);
    }
}
