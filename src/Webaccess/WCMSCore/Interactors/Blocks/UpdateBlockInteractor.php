<?php

namespace Webaccess\WCMSCore\Interactors\Blocks;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;

class UpdateBlockInteractor extends GetBlockInteractor
{
    public function run($blockID, DataStructure $blockStructure)
    {
        if ($block = $this->getBlockByID($blockID)) {
            $block->setInfos($blockStructure);

            if (!$block->getIsGhost()) {
                $block->setInfos($blockStructure);
            }

            if ($block->getIsMaster()) {
                unset($blockStructure->area_id);
                unset($blockStructure->is_master);
                $this->updateChildBlocks($blockStructure, $block->getID());
            }
        }

        Context::get('block_repository')->updateBlock($block);
    }

    private function updateChildBlocks(DataStructure $blockStructure, $blockID)
    {
        $childBlocks = (new GetBlocksInteractor())->getChildBlocks($blockID);

        if (is_array($childBlocks) && sizeof($childBlocks) > 0) {
            foreach ($childBlocks as $child) {
                $this->run($child->getID(), $blockStructure);
            }
        }
    }
}
