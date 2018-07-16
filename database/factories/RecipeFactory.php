<?php

$factory->define(App\Recipe::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
        'short_title' => $faker->optional(0.5)->word,
        'marketing_description' => $faker->optional(0.5)->word, 
        'calories_kcal' => $faker->optional(0.5)->word, 
        'protein_grams' => $faker->optional(0.5)->randomNumber, 
        'fat_grams' => $faker->optional(0.5)->randomNumber, 
        'carbs_grams' => $faker->optional(0.5)->randomNumber, 
        'bulletpoint1' => $faker->optional(0.5)->word, 
        'bulletpoint2' => $faker->optional(0.5)->word, 
        'bulletpoint3' => $faker->optional(0.5)->word, 
        'season' => $faker->optional(0.5)->word, 
        'base' => $faker->optional(0.5)->word, 
        'protein_source' => $faker->optional(0.5)->word, 
        'preparation_time_minutes' => $faker->optional(0.5)->randomNumber, 
        'shelf_life_days' => $faker->optional(0.5)->randomNumber,
        'origin_country' => $faker->optional(0.5)->word, 
        'in_your_box' => $faker->optional(0.5)->word, 
        'gousto_reference' => $faker->optional(0.5)->randomNumber
    ];
});

$factory->state(\App\Recipe::class, 'empty', function ($faker) {
    return [
        'short_title' => null, 
        'marketing_description' => null, 
        'calories_kcal' => null, 
        'protein_grams' => null, 
        'fat_grams' => null, 
        'carbs_grams' => null, 
        'bulletpoint1' => null, 
        'bulletpoint2' => null, 
        'bulletpoint3' => null, 
        'season' => null, 
        'base' => null, 
        'protein_source' => null, 
        'preparation_time_minutes' => null, 
        'shelf_life_days' => null,
        'origin_country' => null, 
        'in_your_box' => null, 
        'gousto_reference' => null,
        'created_at' => "2018-01-01 00:00:00",
        'updated_at' => "2018-01-01 00:00:00"
    ];
});