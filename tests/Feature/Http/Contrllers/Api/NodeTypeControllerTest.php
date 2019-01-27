<?php


namespace Tests\Feature\Http\Contrllers\Api;


use App\Domain\Entity\PbxScheme\NodeType;
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
                        'type',
                    ],
                ],
                'meta' => [
                    'code',
                    'message',
                    'error_code',
                ],
            ]
        );
    }

    public function testCreateNodeTypeAction()
    {
        $response = $this->json(
            'POST', '/api/v1/node-type', [
            'name' => $this->faker->word,
            'type' => $this->faker->word,
        ]
        );
        $response->isOk();
        $response->assertJsonStructure(
            [
                'data' => [

                    'id',
                    'name',
                    'type',

                ],
                'meta' => [
                    'code',
                    'message',
                    'error_code',
                ],
            ]
        );
    }

    public function testDeleteNodeTypeAction()
    {
        $nodeType = factory(NodeType::class)->create();

        $response = $this->json('DELETE', '/api/v1/node-type/' . $nodeType->id);
        $response->isOk();
        $response->assertJson(
            [
                'meta' => [
                    'code'       => 200,
                    'message'    => 'deleted',
                    'error_code' => '',
                ],
            ]
        );
    }

}