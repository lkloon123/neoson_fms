<?php

use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => 'demo123',
        'remember_token' => str_random(10),
        'available' => $faker->boolean(),
    ];
});
