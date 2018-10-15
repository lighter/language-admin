<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Project::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'public' => 1,
        'language' => json_encode(["zh_tw", "zh_cn", "en"]),
    ];
});
