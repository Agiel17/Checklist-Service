<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => app('hash')->make('admin'),
        'remember_token' => str_random(100)
    ];
});

$factory->define(App\Template::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\Checklist::class, function (Faker\Generator $faker) {
    $due = new \DateTime($faker->iso8601($max = 'now'));

    return [
        'object_domain' => $faker->word,
        'object_id' => $faker->randomDigitNotNull,
        'due' => $due->format('Y-m-d H:i:s'),
        'urgency' => $faker->randomDigit,
        'description' => $faker->sentence(5),
        'template_id' => function () {
            return factory(App\Template::class)->create()->id;
        }        
    ];
});

$factory->define(App\Item::class, function (Faker\Generator $faker) {
    $due = new \DateTime($faker->iso8601($max = 'now'));
    return [
        'description' => $faker->sentence(5),
        'due' => $due->format('Y-m-d H:i:s'),
        'urgency' => $faker->randomDigit,
        'assignee_id' => $faker->randomDigit,
        'checklist_id' => function () {
            return factory(App\Checklist::class)->create()->id;
        }        
    ];
});
