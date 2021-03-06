<?php

$factory->define(App\Project::class, function (Faker\Generator $faker) {
    return [
        'name'              => $faker->numerify('Project #######'),
        'short_description' => $faker->sentence,
        'long_description'  => $faker->paragraph,
        'github_link'       => $faker->url,
        'website_link'      => $faker->url,
        'image'             => $faker->imageUrl,
    ];
});

// Example of how to use imap_thread
// $collab_owner = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_project', 'with_user', 'owner')->create();
// $language = factory(App\Language::class)->create();
// $general_skill = $collab_owner->skill;
// $user = $collab_owner->user;
// $user->languages()->attach($language);
// $user->generalSkills()->attach($general_skill);
// $project = $collab_owner->project;
// $project->languages()->attach($language);
// $project->generalSkills()->attach($general_skill, ['count' => 2]);
// $collab_scrub = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_user', 'accepted')->make();
// $skill_scrub = $collab_scrub->skill;
// $collab_scrub->project()->associate($project);
// $collab_scrub->save();
// $project->generalSkills()->attach($skill_scrub, ['count' => 20]);
