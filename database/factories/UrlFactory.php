<?php

declare(strict_types = 1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use App\Models\Url as UrlModel;

$factory->define(UrlModel::class, function (Faker $faker) {

    $url = $faker->unique()->domainName;

    //check if url already exists
    while(UrlModel::where('url', $url)->exists()) {
        $url = $faker->unique()->domainName;
    }

    return [
        'url' => $url,
        'app_id' => \Illuminate\Support\Facades\DB::table('apps')->pluck('id')->random(),
    ];
});
