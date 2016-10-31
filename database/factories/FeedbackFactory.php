<?php

$factory->define(App\Feedback::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->name,
    ];
});
