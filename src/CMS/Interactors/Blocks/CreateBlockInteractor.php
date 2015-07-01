<?php

namespace CMS\Interactors\Blocks;

use CMS\Context;
use CMS\Entities\Block;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\DataStructure;

class CreateBlockInteractor
{
    public function run(DataStructure $blockStructure)
    {
        $block = new Block();
        $block->setInfos($blockStructure);
        $block->valid();

        $blockID = Context::get('block')->createBlock($block);

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
                $childDataStructure = clone $blockStructure;
                $childDataStructure->area_id = $childArea->getID();
                $childDataStructure->master_block_id = $blockID;

                $this->run($childDataStructure);
            }
        }
    }
}
