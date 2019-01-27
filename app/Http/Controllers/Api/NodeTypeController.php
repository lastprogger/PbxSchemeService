<?php


namespace App\Http\Controllers\Api;


use App\Domain\Entity\PbxScheme\NodeType;
use Illuminate\Http\JsonResponse;

class NodeTypeController extends AbstractApiController
{
    public function index(): JsonResponse
    {
        $nodes = NodeType::all(['id', 'name', 'type']);
        return $this->respondOk($nodes->toArray());
    }
}