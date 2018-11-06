<?php

use Faker\Generator as Faker;
use App\Domain\Entity\PbxScheme\PbxScheme;

$factory->define(PbxScheme::class, function (Faker $faker) {
    return [
        'user_id' => $faker->uuid
    ];
});
