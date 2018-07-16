<?php

$factory->define(App\RecipeCuisine::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word
    ];
});
