<?php

$factory->define(App\ChatUser::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->text,
        'seen' => false,
    ];
});
