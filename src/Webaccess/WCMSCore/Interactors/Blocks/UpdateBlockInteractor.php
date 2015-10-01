<?php

namespace Webaccess\WCMSCore\Interactors\Blocks;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Interactors\Versions\UpdatePageVersionInteractor;

class UpdateBlockInteractor extends GetBlockInteractor
{
    public function run($blockID, DataStructure $blockStructure)
    {
        if ($block = $this->getBlockByID($blockID)) {
            $block->setInfos($blockStructure);

            if (!$block->getIsGhost()) {
                $block->setInfos($blockStructure);
            }

            $this->updatePageVersion($block->getID());

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
        array_map(function($childBlock) use ($blockStructure) {
            $this->run($childBlock->getID(), $blockStructure);
        }, (new GetBlocksInteractor())->getChildBlocks($blockID));
    }

    private function updatePageVersion($blockID)
    {
        (new UpdatePageVersionInteractor())->runAfterBlockModification($blockID);
    }
}
