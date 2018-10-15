<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Language::class, function (Faker $faker) {
    return [
        'project_id' => function () {
            return factory(App\Model\Project::class)->create()->id;
        },
        'user_id'    => function () {
            return factory(App\Model\User::class)->create()->id;
        },
        'lang_key'   => $faker->word,
        'lang_value' => json_encode(['zh_tw' => '', 'zh_cn' => '', 'en' => '']),
    ];
});
