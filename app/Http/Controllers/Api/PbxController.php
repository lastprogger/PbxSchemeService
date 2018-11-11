<?php


namespace App\Http\Controllers\Api;


use App\Domain\Entity\Pbx;
use App\Domain\Entity\PbxScheme\PbxScheme;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PbxController extends Controller
{
    public function show(string $apiVersion, string $id, Request $request)
    {
        $validator = Validator::make(['id' => $id], ['id' => 'uuid']);

        if (!$validator->passes()) {
            return response()->make()->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        /** @var Pbx $pbx */
        $pbx = Pbx::find($id);

        if ($pbx === null) {
            return response('Not found', Response::HTTP_NOT_FOUND);
        }
        $pbx->scheme->nodes;
        $pbx->scheme->nodeRelations;
        return response()->json($pbx->toArray());
    }
}
