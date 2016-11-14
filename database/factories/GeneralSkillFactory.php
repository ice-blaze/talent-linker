<?php

$factory->define(App\GeneralSkill::class, function (Faker\Generator $faker) {
    $name = $faker->numerify('GeneralSkill #######');
    $name_snake_case = ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', preg_replace('/ /', '', $name))), '_');

    return [
        'name'           => $name,
        'technical_name' => $name_snake_case,
    ];
});
