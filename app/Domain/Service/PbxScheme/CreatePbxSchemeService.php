<?php
/**
 * Created by PhpStorm.
 * User: S.Karavaev
 * Date: 20.09.2018
 * Time: 22:05
 */

namespace App\Domain\Service\PbxScheme;


use App\Domain\Entity\PbxScheme\PbxScheme;
use App\Domain\Repositories\INodeTypeRepository;
use App\Domain\Repositories\IPbxSchemeNodeRelationRepository;
use App\Domain\Repositories\IPbxSchemeNodeRepository;
use App\Domain\Service\PbxScheme\Exceptions\BadInputDataException;
use App\Http\Requests\PbxScheme\CreatePbxSchemeRequest;
use App\Domain\Entity\PbxScheme\PbxSchemeNode;
use App\Domain\Entity\PbxScheme\PbxSchemeNodeRelation;
use Illuminate\Support\Facades\DB;

class CreatePbxSchemeService
{
    private $nodeTypeRepository;
    private $pbxSchemeNodeRepository;
    private $pbxSchemeNodeRelationRepository;

    /**
     * CreatePbxSchemeService constructor.
     *
     * @param INodeTypeRepository              $nodeTypeRepository
     * @param IPbxSchemeNodeRepository         $pbxSchemeNodeRepository
     * @param IPbxSchemeNodeRelationRepository $pbxSchemeNodeRelationRepository
     */
    public function __construct(
        INodeTypeRepository $nodeTypeRepository,
        IPbxSchemeNodeRepository $pbxSchemeNodeRepository,
        IPbxSchemeNodeRelationRepository $pbxSchemeNodeRelationRepository
    ) {
        $this->nodeTypeRepository              = $nodeTypeRepository;
        $this->pbxSchemeNodeRepository         = $pbxSchemeNodeRepository;
        $this->pbxSchemeNodeRelationRepository = $pbxSchemeNodeRelationRepository;
    }

    /**
     * @param CreatePbxSchemeRequest $request
     *
     * @return PbxScheme
     * @throws BadInputDataException
     */
    public function createPbxScheme(CreatePbxSchemeRequest $request): PbxScheme
    {
        DB::beginTransaction();

        $tmpIdMap = [];

        $pbxScheme = new PbxScheme();
        $pbxScheme->user_id = $request->getUserId();
        $pbxScheme->save();

        foreach ($request->getNodes() as $nodeInputArray) {
            $nodeType = $this->nodeTypeRepository->findById($nodeInputArray['node_type_id']);

            if ($nodeType === null) {
                DB::rollBack();
                throw new BadInputDataException('Not found NodeType ' . $nodeInputArray['node_type_id']);
            }

            $pbxSchemeNode                = new PbxSchemeNode();
            $pbxSchemeNode->pbx_scheme_id = $pbxScheme->id;
            $pbxSchemeNode->node_type_id  = $nodeType->id;
            $pbxSchemeNode->node_type_id  = $nodeType->id;
            $pbxSchemeNode->data          = $nodeInputArray['data'];
            $this->pbxSchemeNodeRepository->save($pbxSchemeNode);

            $tmpIdMap[$nodeInputArray['tmp_id']] = $pbxSchemeNode->id;
        }

        foreach ($request->getRelations() as $relationInputArray) {

            $pbxSchemeRelation                = new PbxSchemeNodeRelation();
            $pbxSchemeRelation->pbx_scheme_id = $pbxScheme->id;
            $pbxSchemeRelation->from_node_id  = $tmpIdMap[$relationInputArray['from_node']];
            $pbxSchemeRelation->to_node_id    = $tmpIdMap[$relationInputArray['to_node']];
            $pbxSchemeRelation->type          = $relationInputArray['type'];
            $this->pbxSchemeNodeRelationRepository->save($pbxSchemeRelation);
        }

        DB::commit();

        return $pbxScheme;
    }
}
