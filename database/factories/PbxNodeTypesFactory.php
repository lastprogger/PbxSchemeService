<?php

use Faker\Generator as Faker;
use \App\Domain\Entity\PbxScheme\NodeType;

$factory->define(NodeType::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'type' => NodeType::TYPE_ACTION
    ];
});

$factory->state(NodeType::class, 'condition', [
    'type' => NodeType::TYPE_CONDITION,
]);

$factory->state(NodeType::class, 'action', [
    'type' => NodeType::TYPE_ACTION,
]);
