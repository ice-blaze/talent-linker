<?php

$factory->define(App\ProjectComment::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->paragraph,
        'private' => false,
    ];
});

$factory->state(App\ProjectComment::class, 'with_user', function ($faker) {
    return [
        'user_id' => function(){
            return factory(App\User::class)->create()->id;
        },
    ];
});

$factory->state(App\ProjectComment::class, 'with_project', function ($faker) {
    return [
        'project_id' => function(){
            return factory(App\Project::class)->create()->id;
        },
    ];
});

$factory->state(App\ProjectComment::class, 'private', function ($faker) {
    return [
        'private' => true,
    ];
});

$factory->state(App\ProjectComment::class, 'public', function ($faker) {
    return [
        'private' => false,
    ];
});

