<?php


namespace Tests\Feature\Http\Contrllers\Api;


use App\Domain\Entity\PbxScheme\NodeType;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use InternalApi\PbxSchemeServiceApi\Facade\UserServiceApiFacade;
use Tests\TestCase;

class NodeTypeControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function testGetAllNodeTypesAction()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjFiNmNjZDJhYjI1NjUxMjg0MTllZDMyYTkxMWRlYjhlZTMyNDgzNGVmMThhNGQ0MGIyMjVkYTkzMDc1NjI5OGYzMjQ3ZmY0YjNhNzNjYzc0In0.eyJhdWQiOiI0IiwianRpIjoiMWI2Y2NkMmFiMjU2NTEyODQxOWVkMzJhOTExZGViOGVlMzI0ODM0ZWYxOGE0ZDQwYjIyNWRhOTMwNzU2Mjk4ZjMyNDdmZjRiM2E3M2NjNzQiLCJpYXQiOjE1NDkxMDU0NjIsIm5iZiI6MTU0OTEwNTQ2MiwiZXhwIjoxNTgwNjQxNDYyLCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.FkTOuqv62armzqxKkBX0awgHmkE2rBcAB_RCVRcC2uz8qZtmcvOr--MEznhgO1LixpO3nRmA7f21xlxm_ZHRjW5ACRo-O256zXJJNEEZCTuAEjzTY5MB6qhSG1QSxBSU9Y1cyb156n2wHsbkLRbKKbS8VPoAAoQgr9o-1kQRm6gkCuiIec-kflQT_GAG1jcuXvi34-3FtyuPm5iaQJQbHqxKqFyAZIJJ2i6WA5y6zdNQQQTqzy4wshDGpLG-EgYVYVe9pEF-AfTQLBF3R_lmjBv3TD5NWaqktW05pUuc3Co91LIhKKcZ__ojK9WI7uck1t7HsfvhY7NsaBeHoOTofijp2SZPYWPWhCgY9VSgKbwsrQsCwehLjL8UjTO6zUglwCZzSd6BikkbuYczgvslK-DpvBGsKlHR5uiS6Bg0CTRYQuJ1RrUfpysQzL97_DhPfdnzIHPoelwHhhQ9EQ59SYUbT1pF91fQsRbXV43YJJiMFF4yfzPmJi3Nb9IOA8yvCdXldmj-RYfLoH3Ia7D1_XzqisNE2zMHCvLeFTPoGDsHi5pD7yIKGN9DUV6uZ01waZw92mgpZBl-4PPNjyIdy00F_qVUp9ms9H9SYgWwwC0G6TzjVGfd1XKn9kARONRN8Jd7qReVp8wQyEDZxeWQSH47sdP4oFJ2YSJeuyJCZyA';



        $res = UserServiceApiFacade::user()->getAuthUser('Bearer ' . $token);

        dd($res);

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