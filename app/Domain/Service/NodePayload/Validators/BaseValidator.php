<?php

namespace App\Domain\Service\NodePayload\Validators;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use phpDocumentor\Reflection\Types\Boolean;

abstract class BaseValidator
{
    /**
     * @var array
     */
    protected $rules = [];
    /**
     * @var array
     */
    protected $messages = [];
    /**
     * @var array
     */
    protected $attributes = [];
    /**
     * @var MessageBag
     */
    protected $errorStack;

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @param array $messages
     */
    public function setMessages(array $messages): void
    {
        $this->messages = $messages;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    /**
     * BaseValidator constructor.
     */
    public function __construct()
    {
        $this->errorStack = new MessageBag();
    }

    /**
     * @return array
     */
    protected function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param array $rules
     */
    protected function setRules(array $rules): void
    {
        $this->rules = $rules;
    }

    /**
     * @param array $data
     *
     * @return MessageBag
     */
    public function validate(array $data): MessageBag
    {
        $validator = Validator::make($data, $this->getRules(), $this->getMessages(), $this->getAttributes());

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            Log::error($e);
            return $validator->errors();
        }

        return $this->errorStack;
    }

    /**
     * @return bool
     */
    public function passes(): bool
    {
        return $this->errorStack->isEmpty();
    }
}