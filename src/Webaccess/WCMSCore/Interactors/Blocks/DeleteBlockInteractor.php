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
        array_map(function($childBlock) {
            Context::get('block_repository')->deleteBlock($childBlock->getID());
        }, (new GetBlocksInteractor())->getChildBlocks($blockID));
    }
}
