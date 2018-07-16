<?php

$factory->define(App\Slug::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word."-".$faker->word."-".$faker->word
    ];
});
