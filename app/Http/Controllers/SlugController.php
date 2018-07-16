<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Transformers\SlugTransformer;
use App\Slug;

use App\Traits\CrudApiControllerTrait;

class SlugController extends ApiController
{
    public $modelClass = Slug::class;
    public $transformerClass = SlugTransformer::class;

    // use traits to get around signature conflict issue
    use CrudApiControllerTrait {
        index as __index;
    } 
}
