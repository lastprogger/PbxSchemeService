<?php


namespace App\Http\Controllers\Api;

use App\Domain\Entity\Pbx;
use App\Http\Requests\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use InternalApi\UserServiceApi\UserServiceApi;

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

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $user = UserServiceApi::getCurrentUser();

        $pbxList = Pbx::query()
                      ->where('company_id', $user->getCompanyId())
                      ->get();

        if ($request->get('with_scheme', false)) {
            $pbxList->load('scheme', 'scheme.nodes', 'scheme.nodeRelations');
        }

        return $this->respondOk($pbxList->toArray());
    }
}
