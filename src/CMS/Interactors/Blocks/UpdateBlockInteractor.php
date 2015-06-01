<?php

namespace CMS\Interactors\Blocks;

use CMS\Context;
use CMS\Structures\BlockStructure;

class UpdateBlockInteractor extends GetBlockInteractor
{
    public function run($blockID, BlockStructure $blockStructure)
    {
        if ($block = $this->getBlockByID($blockID)) {
            if ($blockStructure->type !== null && $blockStructure->type != $block->getType()) {
                $block->setType($blockStructure->type);
            }
            Context::$blockRepository->updateBlockType($block);
        }

        if ($block = $this->getBlockByID($blockID)) {
            $block->setInfos($blockStructure);

            if (!$block->getIsGhost()) {
                $block->updateContent($blockStructure);
            }

            if ($block->getIsMaster()) {
                unset($blockStructure->area_id);
                unset($blockStructure->is_master);
                $this->updateChildBlocks($blockStructure, $block->getID());
            }
        }

        Context::$blockRepository->updateBlock($block);
    }

    private function updateChildBlocks(BlockStructure $blockStructure, $blockID)
    {
        $childBlocks = (new GetBlocksInteractor())->getChildBlocks($blockID);

        if (is_array($childBlocks) && sizeof($childBlocks) > 0) {
            foreach ($childBlocks as $child) {
                $this->run($child->getID(), $blockStructure);
            }
        }
    }
}
