<?php

use Faker\Generator as Faker;

$factory->define(\App\Domain\Entity\Pbx::class, function (Faker $faker) {
    return [
        'user_id' => $faker->uuid,
        'name' => $faker->title
    ];
});
