<?php

use App\Domain\Entity\PbxScheme\PbxSchemeNode;
use Faker\Generator as Faker;

$factory->define(
    PbxSchemeNode::class, function (Faker $faker) {
    return [
        'node_type_id' => $faker->uuid,
        'pbx_scheme_id' => $faker->uuid,
        'data' => []
    ];
});

$factory->state(PbxSchemeNode::class, 'dial', [
    'data' => [
        'endpoint' => 300,
        'music_on_hold' => 'default'
    ]
]);

$factory->state(PbxSchemeNode::class, 'playback', [
    'data' => [
        'filename' => 'default',
    ]
]);
