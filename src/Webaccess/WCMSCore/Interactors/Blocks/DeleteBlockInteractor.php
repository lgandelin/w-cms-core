<?php

namespace Webaccess\WCMSCore\Interactors\Blocks;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Pages\GetPageInteractor;
use Webaccess\WCMSCore\Interactors\Versions\CreatePageVersionInteractor;

class DeleteBlockInteractor extends GetBlockInteractor
{
    public function run($blockID, $newVersion = true)
    {
        $newPageVersion = false;
        if ($block = $this->getBlockByID($blockID)) {
            if ($block->getIsMaster()) {
                $this->deleteChildBlocks($blockID);
            }

            if ($page = (new GetPageInteractor)->getPageFromBlockID($block->getID())) {
                if ($page->isNewVersionNeeded() && $newVersion) {
                    $newPageVersion = true;
                    list($newAreaID, $newBlockID) = (new CreatePageVersionInteractor())->run($page, null, $blockID);
                    $block = (new GetBlockInteractor())->getBlockByID($newBlockID);
                }
            }

            $this->deleteBlock($block->getID());
        }

        return $newPageVersion;
    }

    private function deleteBlock($blockID)
    {
        Context::get('block_repository')->deleteBlock($blockID);
    }

    private function deleteChildBlocks($blockID)
    {
        array_map(function($childBlock) {
            Context::get('block_repository')->deleteBlock($childBlock->getID());
        }, (new GetBlocksInteractor())->getChildBlocks($blockID));
    }
}
