<?php

$factory->define(App\Review::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->optional(0.5)->word,
        'content' => $faker->optional(0.5)->sentence,
        'rating' => $faker->numberBetween(1,5)
    ];
});
