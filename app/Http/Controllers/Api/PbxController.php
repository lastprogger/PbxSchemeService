<?php


namespace App\Http\Controllers\Api;

use App\Domain\Entity\Pbx;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Validator;

class PbxController extends AbstractApiController
{
    public function show(string $apiVersion, string $id, Request $request)
    {
        $validator = Validator::make(['id' => $id], ['id' => 'uuid']);

        if (!$validator->passes()) {
            return $this->respondNotFound();
        }

        /** @var Pbx $pbx */
//        $pbx = Pbx::find($id);
        $pbx = Pbx::query()->where('id', $id)->first()->load('scheme', 'scheme.nodes', 'scheme.nodeRelations');

        if ($pbx === null) {
            return $this->respondNotFound();
        }

        return response()->json($pbx->toArray());
    }
}
