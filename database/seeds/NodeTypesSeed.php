<?php

use App\Domain\Entity\PbxScheme\NodeType;
use Illuminate\Database\Seeder;

class NodeTypesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(NodeType::class)->create(
            [
                'name' => NodeType::NAME_DIAL,
                'type' => NodeType::TYPE_ACTION,
            ]
        );

        factory(NodeType::class)->create(
            [
                'name' => NodeType::NAME_PLAYBACK,
                'type' => NodeType::TYPE_ACTION,
            ]
        );
    }
}
