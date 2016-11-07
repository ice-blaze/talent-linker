<?php

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'               => $faker->name,
        'last_name'          => $faker->lastName,
        'first_name'         => $faker->firstName,
        'talent_description' => $faker->text,
        'email'              => $faker->safeEmail,
        'password'           => bcrypt('test'),
        'remember_token'     => str_random(10),
    ];
});
