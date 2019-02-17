<?php

use App\Domain\Entity\PbxScheme\PbxSchemeNodeRelation;
use Faker\Generator as Faker;
use \App\Domain\Entity\PbxScheme\NodeType;

$factory->define(
    PbxSchemeNodeRelation::class, function (Faker $faker) {
    return [
        'type' => array_rand(['negative', 'positive', 'direct']),
        'from_node_id' => $faker->uuid,
        'to_node_id' => $faker->uuid,
        'pbx_scheme_id' => $faker->uuid,
    ];
});

$factory->state(PbxSchemeNodeRelation::class, 'direct', [
    'type' => PbxSchemeNodeRelation::TYPE_DIRECT,
]);

$factory->state(PbxSchemeNodeRelation::class, 'positive', [
    'type' => PbxSchemeNodeRelation::TYPE_POSITIVE,
]);

$factory->state(PbxSchemeNodeRelation::class, 'negative', [
    'type' => PbxSchemeNodeRelation::TYPE_NEGATIVE,
]);
