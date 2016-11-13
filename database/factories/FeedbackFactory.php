<?php

$factory->define(App\Feedback::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->text,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
    ];
});

$factory->defineAs(App\Feedback::class, 'no_user', function (Faker\Generator $faker) {
    return [
        'content' => $faker->text,
    ];
});

// How to use
// $feedback = factory(App\Feedback::class, 'no_user')
//     ->make()
//     ->each(function ($f) {
//         $f->user(factory(App\User::class)->create());
//     });
// $feedback = factory(App\Feedback::class)
//     ->create();
// }