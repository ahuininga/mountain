<?php

declare(strict_types = 1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use App\Models\Role as RoleModel;

$factory->define(RoleModel::class, function (Faker $faker) {

    return [
        'name' => $faker->jobTitle,
    ];
});
