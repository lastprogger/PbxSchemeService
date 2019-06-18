<?php

namespace App\Domain\Service\NodePayload\Validators;

class DialNodeValidator extends BaseValidator
{
    protected $messages = [
      'phone_number_id.uuid' => 'invalid phone number Id'
    ];

    protected $rules = [
        'phone_number_id' => 'required|uuid',
        'music_on_hold'   => 'string',
    ];
}