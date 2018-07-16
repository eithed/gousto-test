<?php

$factory->define(App\RecipeEquipment::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word
    ];
});
