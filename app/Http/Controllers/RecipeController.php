<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Transformers\RecipeTransformer;
use App\Http\Requests\RecipeStoreRequest;
use App\Http\Requests\RecipeUpdateRequest;
use App\Http\Requests\RecipeReviewRequest;

use App\Services\RecipeService;
use App\Services\ReviewService;

use App\Recipe;
use App\Review;

use App\Traits\CrudApiControllerTrait;

class RecipeController extends ApiController
{
    static public $modelClass = Recipe::class;
    static public $transformerClass = RecipeTransformer::class;
    static public $serviceClass = RecipeService::class;

    // use traits to get around signature conflict issue
    use CrudApiControllerTrait {
        index as __index;
        show as __show;
        store as __store;
        update as __update;
        destroy as __destroy;
    }

    public function index(Request $request)
    {
        return $this->__index($request, function($builder) use ($request){
            if ($request->has('recipe_cuisine_id'))
                $builder->whereHas('recipeCuisines', function($query) use ($request){
                    $query->where('id', $request->get('recipe_cuisine_id'));
                });
        });
    }

    public function show(Recipe $recipe, Request $request)
    {
        return $this->__show($recipe, $request);
    }

    public function store(RecipeStoreRequest $request)
    {
        return $this->__store($request);
    }

    public function update(Recipe $recipe, RecipeUpdateRequest $request)
    {
        return $this->__update($recipe, $request);
    }

    public function destroy(Recipe $recipe, Request $request)
    {
        return $this->__destroy($recipe, $request);
    }

    public function rate(Recipe $recipe, RecipeReviewRequest $request, ReviewService $reviewService)
    {
        $review = new Review($request->all());
        $result = $reviewService->store($review, $recipe, $request);

        return response()->json($result ? [
            'message' => sprintf("%s %s has been successfully reviewed", $recipe->singular, $recipe->id)
        ] : [
            'message' => sprintf("Could not review %s %s", $recipe->singular, $recipe->id)
        ]);
    }
}
