<?php

namespace Tests\Feature\Http\Contrllers\Api;


use App\Domain\Entity\Pbx;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PbxControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testShowAction()
    {
        $this->seed(\PbxSeeder::class);

        /** @var Pbx $pbx */
        $pbx = Pbx::first();

        $response = $this->json(
            'GET',
            '/api/v1/pbx/' . $pbx->id,
            [],
            [
                'Accept' => 'Application/json',
            ]
        );
        $response->assertOk();
        $response->assertJsonStructure(
            [
                'id',
                'name',
                'scheme' => [
                    'id',
                    'created_at',
                    'nodes' => [
                        [
                            'id'
                        ]
                    ],
                    'node_relations' => [
                        [
                            'id'
                        ]
                    ]
                ],
            ]
        );
    }

}
