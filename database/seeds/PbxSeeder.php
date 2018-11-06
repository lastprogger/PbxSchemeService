<?php

use Illuminate\Database\Seeder;
use App\Domain\Entity\Pbx;
use App\Domain\Entity\PbxScheme\PbxScheme;
use App\Domain\Entity\PbxScheme\NodeType;
use App\Domain\Entity\PbxScheme\PbxSchemeNode;
use App\Domain\Entity\PbxScheme\PbxSchemeNodeRelation;

class PbxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pbxScheme      = factory(PbxScheme::class)->create();
        $nodeTypeBasic1 = factory(NodeType::class)->state(NodeType::TYPE_BASIC)->create();
        $nodeTypeBasic2 = factory(NodeType::class)->state(NodeType::TYPE_BASIC)->create();

        $node1                = new PbxSchemeNode();
        $node1->pbx_scheme_id = $pbxScheme->id;
        $node1->node_type_id  = $nodeTypeBasic1->id;
        $node1->data          = ['data' => 'test data'];
        $node1->save();

        $node2                = new PbxSchemeNode();
        $node2->pbx_scheme_id = $pbxScheme->id;
        $node2->node_type_id  = $nodeTypeBasic2->id;
        $node2->data          = ['data' => 'test data 2'];
        $node2->save();

        $relation                = new PbxSchemeNodeRelation();
        $relation->pbx_scheme_id = $pbxScheme->id;
        $relation->type          = PbxSchemeNodeRelation::TYPE_NEGATIVE;
        $relation->from_node_id  = $node1->id;
        $relation->to_node_id    = $node2->id;
        $relation->save();

        factory(Pbx::class)->create(
            [
                'pbx_scheme_id' => $pbxScheme->id
            ]
        );
    }
}
