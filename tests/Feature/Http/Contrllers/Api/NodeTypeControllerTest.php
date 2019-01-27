<?php


namespace Tests\Feature\Http\Contrllers\Api;


use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NodeTypeControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function testGetAllNodeTypesAction()
    {
        $response = $this->json('GET', '/api/v1/node-type');
        $response->isOk();
        $response->assertJsonStructure(
            [
                'data' => [
                    [
                        'id',
                        'name',
                        'type'
                    ]
                ],
                'meta' => [
                    'code',
                    'message',
                    'error_code'
                ]
            ]
        );
    }

}