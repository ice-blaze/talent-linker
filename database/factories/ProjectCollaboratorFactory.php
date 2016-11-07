<?php

$factory->define(App\ProjectCollaborator::class, function (Faker\Generator $faker) {
    return [
        'is_project_owner'  => false,
        'from_collaborator' => false,
        'accepted'          => false,
        'invite_message'    => $faker->sentence,
    ];
});

$factory->state(App\ProjectCollaborator::class, 'with_skill', function ($faker) {
    return [
        'skill_id' => function () {
            return factory(App\GeneralSkill::class)->create()->id;
        },
    ];
});

$factory->state(App\ProjectCollaborator::class, 'with_project', function ($faker) {
    return [
        'project_id' => function () {
            return factory(App\Project::class)->create()->id;
        },
    ];
});

$factory->state(App\ProjectCollaborator::class, 'with_user', function ($faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
    ];
});

$factory->state(App\ProjectCollaborator::class, 'from_collaborator', function ($faker) {
    return [
        'from_collaborator' => true,
    ];
});

$factory->state(App\ProjectCollaborator::class, 'accepted', function ($faker) {
    return [
        'accepted'      => true,
        'accepted_date' => $faker->dateTime,
    ];
});

$factory->state(App\ProjectCollaborator::class, 'owner', function ($faker) {
    return [
        'is_project_owner' => true,
        'accepted'         => true,
        'accepted_date'    => $faker->dateTime,
    ];
});
