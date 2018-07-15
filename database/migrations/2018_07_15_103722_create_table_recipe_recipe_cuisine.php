<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRecipeRecipeCuisine extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_recipe_cuisine', function (Blueprint $table) {
            $table->integer('recipe_id')->unsigned()->index();
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');

            $table->integer('recipe_cuisine_id')->unsigned()->index();
            $table->foreign('recipe_cuisine_id')->references('id')->on('recipe_cuisines')->onDelete('cascade');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('recipe_recipe_cuisine');
    }
}
