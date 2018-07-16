<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Recipe;
use App\RecipeBoxType;
use App\RecipeCuisine;
use App\RecipeDietType;
use App\Slug;

Route::group(['prefix' => Recipe::namespace()], function(){
	Route::get('/', ['uses' => RecipeController::class."@index"]);
	Route::get('/{recipe}/', ['uses' => RecipeController::class."@show"]);
	Route::post('/', ['uses' => RecipeController::class."@store"]);
	Route::post('/{recipe}/review', ['uses' => RecipeController::class."@review"]);
	Route::put('/{recipe}/', ['uses' => RecipeController::class."@update"]);
	Route::delete('/{recipe}/', ['uses' => RecipeController::class."@destroy"]);
});

Route::group(['prefix' => RecipeBoxType::namespace()], function(){
	Route::get('/', ['uses' => RecipeBoxTypeController::class."@index"]);
	Route::get('/{recipeBoxType}/', ['uses' => RecipeBoxTypeController::class."@show"]);
	Route::post('/', ['uses' => RecipeBoxTypeController::class."@store"]);
	Route::put('/{recipeBoxType}/', ['uses' => RecipeBoxTypeController::class."@update"]);
	Route::delete('/{recipeBoxType}/', ['uses' => RecipeBoxTypeController::class."@destroy"]);
});

Route::group(['prefix' => RecipeCuisine::namespace()], function(){
	Route::get('/', ['uses' => RecipeCuisineController::class."@index"]);
	Route::get('/{recipeCuisine}/', ['uses' => RecipeBoxTypeController::class."@show"]);
});

Route::group(['prefix' => RecipeDietType::namespace()], function(){
	Route::get('/', ['uses' => RecipeDietTypeController::class."@index"]);
	Route::get('/{recipeDietType}/', ['uses' => RecipeDietTypeController::class."@show"]);
});

Route::group(['prefix' => Slug::namespace()], function(){
	Route::get('/', ['uses' => SlugController::class."@index"]);
});