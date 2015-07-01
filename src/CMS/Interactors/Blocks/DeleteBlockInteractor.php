<?php

namespace CMS\Interactors\Blocks;

use CMS\Context;

class DeleteBlockInteractor extends GetBlockInteractor
{
    public function run($blockID)
    {
        if ($block = $this->getBlockByID($blockID)) {

            if ($block->getIsMaster()) {
                $this->deleteChildBlocks($blockID);
            }

            Context::get('block')->deleteBlock($blockID);
        }
    }

    private function deleteChildBlocks($blockID)
    {
        $childBlocks = (new GetBlocksInteractor())->getChildBlocks($blockID);

        if (is_array($childBlocks) && sizeof($childBlocks) > 0) {
            foreach ($childBlocks as $childBlock) {
                Context::get('block')->deleteBlock($childBlock->getID());
            }
        }
    }
}
