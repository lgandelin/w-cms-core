<?php

namespace Webaccess\WCMSCore\Interactors\Blocks;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Block;
use Webaccess\WCMSCore\Interactors\Areas\GetAreasInteractor;
use Webaccess\WCMSCore\DataStructure;

class CreateBlockInteractor
{
    public function run(DataStructure $blockStructure)
    {
        $block = (new Block())->setInfos($blockStructure);
        $block->valid();

        $blockID = Context::get('block_repository')->createBlock($block);

        if ($block->getIsMaster()) {
            $this->createBlockInChildAreas($blockStructure, $blockID, $block->getAreaID());
        }

        return $blockID;
    }

    private function createBlockInChildAreas($blockStructure, $blockID, $areaID)
    {
        array_map(function($childArea) use ($blockStructure, $blockID) {
            $childDataStructure = clone $blockStructure;
            $childDataStructure->area_id = $childArea->getID();
            $childDataStructure->master_block_id = $blockID;

            $this->run($childDataStructure);
        }, (new GetAreasInteractor())->getChildAreas($areaID));
    }
}
