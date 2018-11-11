<?php
/**
 * Created by PhpStorm.
 * User: S.Karavaev
 * Date: 09.09.2018
 * Time: 0:35
 */

namespace App\Http\Controllers\Api;


use App\Domain\Service\PbxScheme\CreatePbxSchemeService;
use App\Domain\Service\PbxScheme\Exceptions\BadInputDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\PbxScheme\CreatePbxSchemeRequest;
use App\Domain\Entity\Pbx;
use App\Http\Requests\Request;
use Illuminate\Http\Response;

class PbxSchemeController extends Controller
{
    /**
     * @param CreatePbxSchemeRequest $request
     * @param CreatePbxSchemeService $createPbxSchemeService
     *
     * @return Response
     */
    public function store(CreatePbxSchemeRequest $request, CreatePbxSchemeService $createPbxSchemeService)
    {
        try {
            $pbxScheme = $createPbxSchemeService->createPbxScheme($request);

            $pbx = new Pbx();
            $pbx->pbx_scheme_id = $pbxScheme->id;
            $pbx->user_id = $request->getUserId();
            $pbx->save();

            return response()->json(
                [
                    'id' => $pbx->id
                ]
            );
        } catch (BadInputDataException $e) {
            return response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return response('INTERNAL SERVER ERROR', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
