<?php

$factory->define(App\ChatUser::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->text,
        'reciever_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'sender_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'seen' => false,
    ];
});

$factory->defineAs(App\ChatUser::class, 'no_users', function (Faker\Generator $faker) {
    return [
        'content' => $faker->text,
        'seen' => false,
    ];
});

$factory->state(App\ChatUser::class, 'seen', function ($faker) {
    return [
        'seen' => true,
    ];
});

$factory->state(App\ChatUser::class, 'unseen', function ($faker) {
    return [
        'seen' => false,
    ];
});