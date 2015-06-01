<?php

namespace CMS\Interactors\Blocks;

use CMS\Structures\BlockStructure;

class DuplicateBlockInteractor
{
    public function run(BlockStructure $blockStructure, $newAreaID)
    {
        $blockStructure->ID = null;
        $blockStructure->area_id = $newAreaID;

        $blockID = (new CreateBlockInteractor())->run($blockStructure);
        (new UpdateBlockInteractor())->run($blockID, $blockStructure);

        return $blockID;
    }
}
