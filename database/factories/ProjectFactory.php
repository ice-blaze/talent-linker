<?php

$factory->define(App\Project::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'short_description' => $faker->text,
        'long_description' => $faker->text,
        'github_link' => $faker->link,
        'siteweb_link' => $faker->link,
        // 'post_id' => App\Post::all()->random()->id,
    ];
});
