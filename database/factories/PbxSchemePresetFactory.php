<?php

use App\Domain\Entity\PbxSchemePreset;
use Faker\Generator as Faker;

$factory->define(
    PbxSchemePreset::class, function (Faker $faker) {
    return [
        'pbx_scheme_id' => $faker->uuid,
        'name' => $faker->title
    ];
});
