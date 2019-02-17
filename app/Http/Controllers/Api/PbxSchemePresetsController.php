<?php
/**
 * Created by PhpStorm.
 * User: S.Karavaev
 * Date: 09.09.2018
 * Time: 0:35
 */

namespace App\Http\Controllers\Api;

use App\Domain\Entity\PbxScheme\PbxScheme;
use App\Domain\Entity\PbxScheme\PbxSchemePreset;
use App\Http\Requests\CreatePbxSchemePresetRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PbxSchemePresetsController extends AbstractApiController
{
    /**
     * @param string $apiVersion
     * @param string $pbxSchemeId
     *
     * @return JsonResponse
     */
    public function index(string $apiVersion): JsonResponse
    {
        /** @var PbxScheme $pbxScheme */
        $presets = PbxSchemePreset::all();
        $presets->load('scheme', 'scheme.nodes', 'scheme.nodeRelations');

        return $this->respond($presets->toArray());
    }

    /**
     * @param string                       $apiVersion
     * @param CreatePbxSchemePresetRequest $request
     *
     * @return JsonResponse
     */
    public function store(string $apiVersion, CreatePbxSchemePresetRequest $request): JsonResponse
    {
        if (PbxScheme::find($request->getPbxSchemeId()) === null) {
            $this->respond([], 'Pbx scheme not found', Response::HTTP_BAD_REQUEST);
        }

        $preset = new PbxSchemePreset();
        $preset->name = $request->getName();
        $preset->pbx_scheme_id = $request->getPbxSchemeId();
        $preset->save();

        return $this->respondOk($preset->toArray());
    }

    /**
     * @param string $apiVersion
     * @param string $id
     *
     * @return JsonResponse
     */
    public function show(string $apiVersion, string $id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], ['id' => 'uuid']);

        if (!$validator->passes()) {
            return $this->respondNotFound();
        }

        $preset = PbxSchemePreset::find($id);

        if ($preset === null) {
            return $this->respondNotFound();
        }

        $preset->load('scheme', 'scheme.nodes', 'scheme.nodeRelations');

        return $this->respondOk($preset->toArray());
    }

    /**
     * @param string $apiVersion
     * @param string $id
     *
     * @return JsonResponse
     */
    public function destroy(string $apiVersion, string $id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], ['id' => 'uuid']);

        if (!$validator->passes()) {
            return $this->respondNotFound();
        }

        $preset = PbxSchemePreset::find($id);

        if ($preset === null) {
            return $this->respondNotFound();
        }

        $preset->delete();

        return $this->respondOk([], 'deleted');
    }

}
