<?php
/**
 * Created by PhpStorm.
 * User: S.Karavaev
 * Date: 20.09.2018
 * Time: 21:46
 */

namespace App\Http\Requests\PbxScheme;


use App\Http\Requests\AbstractApiRequest;

class CreatePbxSchemeRequest extends AbstractApiRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'pbx_id'                => 'int',
            'nodes'                 => 'required|array',
            'nodes.*.tmp_id'        => 'required|string',
            'nodes.*.node_type_id'  => 'required|string',
            'nodes.*.data'          => 'required|array',
            'relations'             => 'required|array',
            'relations.*.type'      => 'required|string',
            'relations.*.from_node' => 'required|string',
            'relations.*.to_node'   => 'required|string',
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
