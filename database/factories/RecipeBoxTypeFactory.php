<?php

$factory->define(App\RecipeBoxType::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word
    ];
});
