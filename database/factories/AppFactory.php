<?php

declare(strict_types = 1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use App\Models\App as AppModel;

$factory->define(AppModel::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'user_id' => \Illuminate\Support\Facades\DB::table('users')->pluck('id')->random(),
        'active' => $faker->boolean(90),
    ];
});
