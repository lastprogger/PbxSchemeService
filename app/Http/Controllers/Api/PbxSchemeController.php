<?php
/**
 * Created by PhpStorm.
 * User: S.Karavaev
 * Date: 09.09.2018
 * Time: 0:35
 */

namespace App\Http\Controllers\Api;


use App\Domain\Entity\PbxScheme\PbxScheme;
use App\Domain\Entity\PbxScheme\PbxSchemeNodeRelation;
use App\Domain\Service\PbxScheme\CreatePbxSchemeService;
use App\Domain\Service\PbxScheme\Exceptions\BadInputDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\PbxScheme\CreatePbxSchemeRequest;
use App\Domain\Entity\Pbx;
use App\Http\Requests\Request;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use InternalApi\DialplanBuilderService\DialplanBuilderServiceApi;
use InternalApi\UserServiceApi\UserServiceApi;
use Ramsey\Uuid\Uuid;

class PbxSchemeController extends AbstractApiController
{
    /**
     * @var DialplanBuilderServiceApi
     */
    private $dialplanBuilderService;

    public function __construct()
    {
        $this->dialplanBuilderService = app('dialplan_builder_service_api');
    }

    /**
     * @param CreatePbxSchemeRequest $request
     * @param CreatePbxSchemeService $createPbxSchemeService
     *
     * @return JsonResponse
     */
    public function store(CreatePbxSchemeRequest $request, CreatePbxSchemeService $createPbxSchemeService): JsonResponse
    {
        $user = UserServiceApi::getCurrentUser();

        try {
            if ($request->getPbxId() === null) {
                $pbx          = new Pbx();
                $pbx->user_id = $user->getId();
                $pbx->company_id = $user->getCompanyId();

            } else {
                $pbx = Pbx::query()->where('id', $request->getPbxId())->first();

                if ($pbx === null) {
                    $this->respondWithError('PBX not found', Response::HTTP_BAD_REQUEST);
                }
            }

            DB::beginTransaction();
            $pbxScheme = $createPbxSchemeService->createPbxScheme($request);

            $pbx->pbx_scheme_id = $pbxScheme->id;
            $pbx->save();

            $data = [
                'pbx_id'        => $pbx->id,
                'pbx_scheme_id' => $pbxScheme->id,
                'company_id'    => $user->getCompanyId(),
            ];

            foreach ($pbxScheme->nodes as $node) {
                $data['nodes'][] = [
                    'id'        => $node->id,
                    'data'      => $node->data,
                    'node_type' => [
                        'name' => $node->nodeType->name,
                        'type' => $node->nodeType->type,
                    ],
                ];
            }

            foreach ($pbxScheme->nodeRelations as $relation) {
                $data['node_relations'][] = [
                    'type'         => $relation->type,
                    'from_node_id' => $relation->from_node_id,
                    'to_node_id'   => $relation->to_node_id,
                ];
            }

            $res = $this->dialplanBuilderService->dialplan()->create($data);

            if ($res === null || $res['meta']['code'] !== Response::HTTP_OK) {
                DB::rollBack();

                return $this->respondWithError('PBX creating failed', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            DB::commit();

            return $this->respondOk($pbxScheme->toArray(), 'Successfully saved');

        } catch (BadInputDataException $e) {
            DB::rollBack();

            return $this->respondWithError($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->respondInternalError();
        }
    }

    /**
     * @param string $apiVersion
     * @param string $pbxSchemeId
     *
     * @return JsonResponse
     */
    public function show(string $apiVersion, string $pbxSchemeId): JsonResponse
    {
        $validator = Validator::make(['id' => $pbxSchemeId], ['id' => 'uuid']);

        if(!$validator->passes()) {
            $this->respondNotFound();
        }
        /** @var PbxScheme $pbxScheme */
        $pbxScheme = PbxScheme::find($pbxSchemeId);

        if ($pbxScheme === null) {
            return $this->respondNotFound();
        }

        $pbxScheme->load('nodeRelations', 'nodes');

        return $this->respond($pbxScheme->toArray());
    }
}
