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
        'find_distance'      => 1.0, // default value didn't work for unknown reason
    ];
});

$factory->state(App\User::class, 'geo_neuchatel', function ($faker) {
    return [
        'lat' => 46.991363,
        'lng' => 6.929970,
    ];
});

$factory->state(App\User::class, 'geo_osaka', function ($faker) {
    return [
        'lat' => 34.6937,
        'lng' => 135.5022,
    ];
});

$factory->state(App\User::class, 'admin', function ($faker) {
    return [
        'is_admin' => 1,
    ];
});
