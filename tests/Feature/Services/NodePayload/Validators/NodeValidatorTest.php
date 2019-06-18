<?php


namespace Tests\Feature\Services\NodePayload\Validators;


use App\Domain\Service\NodePayload\Validators\DialNodeValidator;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class NodeValidatorTest extends TestCase
{
    use WithFaker;

    public function testNodeDialNodeValidator()
    {
        $validator = new DialNodeValidator();
            $validator->validate(
                [
                    'phone_number_id' => 'asd',
                ]
            );



        dd($validator->passes());
    }
}