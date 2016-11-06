<?php

$factory->define(App\Feedback::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->text,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        }
    ];
});

$factory->defineAs(App\Feedback::class, 'no_user', function (Faker\Generator $faker) {
    return [
        'content' => $faker->text,
    ];
});
