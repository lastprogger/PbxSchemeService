<?php

namespace App\Http\Controllers\Api;

use App\Domain\Entity\PbxScheme\NodeType;
use App\Http\Requests\CreateNodeTypeRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class NodeTypeController extends AbstractApiController
{
    public function index(): JsonResponse
    {
        $nodes = NodeType::all(['id', 'name', 'type']);

        return $this->respondOk($nodes->toArray());
    }

    /**
     * @return JsonResponse
     */
    public function store(CreateNodeTypeRequest $request): JsonResponse
    {
        try {

            $nodeType       = new NodeType();
            $nodeType->name = $request->getName();
            $nodeType->type = $request->getType();
            $nodeType->save();
            $nodeType->refresh();

            return $this->respondOk($nodeType->toArray());

        } catch (Exception $e) {
            return $this->respondInternalError();
        }
    }

    /**
     * @param string $apiVersion
     * @param string $id
     *
     * @return JsonResponse
     */
    public function destroy(string $apiVersion, string $id)
    {
        try {
            $nodeType = NodeType::query()->find($id);

            if ($nodeType === null) {
                $this->respondNotFound();
            }

            $nodeType->delete();

            return $this->respondOk([], 'deleted');

        } catch (Exception $e) {
            return $this->respondInternalError();
        }
    }
}