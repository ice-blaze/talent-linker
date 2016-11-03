<?php

$factory->define(App\Project::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});
