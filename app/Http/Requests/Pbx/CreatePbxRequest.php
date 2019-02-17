<?php
/**
 * Created by PhpStorm.
 * User: S.Karavaev
 * Date: 20.09.2018
 * Time: 21:46
 */

namespace App\Http\Requests\Pbx;


use App\Http\Requests\AbstractApiRequest;

class CreatePbxSchemeRequest extends AbstractApiRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'preset' => 'string|in:simple',
        ];
    }

    /**
     * @return int|null
     */
    public function getPbxId(): ?int
    {
        return $this->input('pbx_id');
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return $this->input('nodes');
    }

    /**
     * @return array
     */
    public function getRelations(): array
    {
        return $this->input('relations');
    }
}
