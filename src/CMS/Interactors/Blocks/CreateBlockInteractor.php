<?php

namespace CMS\Interactors\Blocks;

use CMS\Context;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Structures\BlockStructure;

class CreateBlockInteractor
{
    public function run(BlockStructure $blockStructure)
    {
        $block = $blockStructure->getBlock();
        $block->setInfos($blockStructure);
        $block->valid();

        $blockID = Context::getRepository('block')->createBlock($block);

        if ($block->getIsMaster()) {
            $this->createBlockInChildAreas($blockStructure, $blockID, $block->getAreaID());
        }

        return $blockID;
    }

    private function createBlockInChildAreas($blockStructure, $blockID, $areaID)
    {
        $childAreas = (new GetAreasInteractor())->getChildAreas($areaID);

        if (is_array($childAreas) && sizeof($childAreas) > 0) {
            foreach ($childAreas as $childArea) {
                $childBlockStructure = clone $blockStructure;
                $childBlockStructure->area_id = $childArea->getID();
                $childBlockStructure->master_block_id = $blockID;

                $this->run($childBlockStructure);
            }
        }
    }
}
