<?php

namespace App\Http\Requests;

class CreateNodeTypeRequest extends AbstractApiRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
          'name' => 'required|string',
          'type' => 'required|string'
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('name');
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->get('type');
    }
}