<?php

namespace App\Http\Requests;

class CreatePbxSchemePresetRequest extends AbstractApiRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
          'name' => 'required|string',
          'pbx_scheme_id' => 'required|uuid'
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
    public function getPbxSchemeId(): string
    {
        return $this->get('pbx_scheme_id');
    }
}