<?php

namespace Webaccess\WCMSCore\Interactors\Blocks;

use Webaccess\WCMSCore\DataStructure;

class DuplicateBlockInteractor
{
    public function run(DataStructure $blockStructure, $newAreaID)
    {
        $blockStructure->ID = null;
        $blockStructure->area_id = $newAreaID;

        $blockID = (new CreateBlockInteractor())->run($blockStructure);
        (new UpdateBlockInteractor())->run($blockID, $blockStructure);

        return $blockID;
    }
}
