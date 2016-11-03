<?php

$factory->define(App\Language::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});
