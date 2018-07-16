<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Transformers\RecipeBoxTypeTransformer;
use App\Http\Requests\RecipeBoxTypeStoreRequest;
use App\Http\Requests\RecipeBoxTypeUpdateRequest;

use App\RecipeBoxType;

use App\Traits\CrudApiControllerTrait;

class RecipeBoxTypeController extends ApiController
{
    public $modelClass = RecipeBoxType::class;
    public $transformerClass = RecipeBoxTypeTransformer::class;

    // use traits to get around signature conflict issue
    use CrudApiControllerTrait {
        index as __index;
        show as __show;
        store as __store;
        update as __update;
        destroy as __destroy;
    }

    public function show(RecipeBoxType $recipeBoxType, Request $request)
    {
        return $this->__show($recipeBoxType, $request);
    }

    public function store(RecipeBoxTypeStoreRequest $request)
    {
        return $this->__store($request);
    }

    public function update(RecipeBoxType $recipeBoxType, RecipeBoxTypeUpdateRequest $request)
    {
        return $this->__update($recipeBoxType, $request);
    }

    public function destroy(RecipeBoxType $recipeBoxType, Request $request)
    {
        return $this->__destroy($recipeBoxType, $request);
    }
}
