<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRecipeRecipeDietType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_recipe_diet_type', function (Blueprint $table) {
            $table->integer('recipe_id')->unsigned()->index();
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');

            $table->integer('recipe_diet_type_id')->unsigned()->index();
            $table->foreign('recipe_diet_type_id')->references('id')->on('recipe_diet_types')->onDelete('cascade');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('recipe_recipe_diet_type');
    }
}
