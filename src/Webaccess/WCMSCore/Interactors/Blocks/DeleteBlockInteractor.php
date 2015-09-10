<?php

namespace Webaccess\WCMSCore\Interactors\Blocks;

use Webaccess\WCMSCore\Context;

class DeleteBlockInteractor extends GetBlockInteractor
{
    public function run($blockID)
    {
        if ($block = $this->getBlockByID($blockID)) {

            if ($block->getIsMaster()) {
                $this->deleteChildBlocks($blockID);
            }

            Context::get('block_repository')->deleteBlock($blockID);
        }
    }

    private function deleteChildBlocks($blockID)
    {
        $childBlocks = (new GetBlocksInteractor())->getChildBlocks($blockID);

        if (is_array($childBlocks) && sizeof($childBlocks) > 0) {
            foreach ($childBlocks as $childBlock) {
                Context::get('block_repository')->deleteBlock($childBlock->getID());
            }
        }
    }
}
