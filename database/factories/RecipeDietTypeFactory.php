<?php

$factory->define(App\RecipeDietType::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word
    ];
});
