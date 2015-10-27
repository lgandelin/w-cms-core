<?php

namespace Webaccess\WCMSCore\Interactors\Blocks;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Interactors\Pages\GetPageInteractor;
use Webaccess\WCMSCore\Interactors\Versions\CreatePageVersionInteractor;

class UpdateBlockInteractor extends GetBlockInteractor
{
    public function run($blockID, DataStructure $blockStructure, $newVersion = true)
    {
        $newPageVersion = false;
        if ($block = $this->getBlockByID($blockID)) {
            if ($page = (new GetPageInteractor)->getPageFromBlockID($block->getID())) {
                if ($page->isNewVersionNeeded() && $newVersion) {
                    $newPageVersion = true;
                    list($newAreaID, $newBlockID, $versionNumber) = (new CreatePageVersionInteractor())->run($page, null, $blockID);
                    $block = (new GetBlockInteractor())->getBlockByID($newBlockID);
                    $blockStructure->ID = $newBlockID;
                    $blockStructure->versionNumber = $versionNumber;
                    $blockStructure->areaID = $newAreaID;
                }
                $this->updateBlock($blockStructure, $block);

                /*if ($block->getIsMaster()) {
                    $this->updateChildBlocks($blockStructure, $block->getID());
                }*/
            }
        }

        return $newPageVersion;
    }

    private function updateBlock(DataStructure $blockStructure, $block)
    {
        if (!$block->getIsGhost()) {
            $block->setInfos($blockStructure);
            Context::get('block_repository')->updateBlock($block);
        }
    }

    /*private function updateChildBlocks(DataStructure $blockStructure, $blockID)
    {
        unset($blockStructure->area_id);
        unset($blockStructure->is_master);
        array_map(function($childBlock) use ($blockStructure) {
            $this->run($childBlock->getID(), $blockStructure);
        }, (new GetBlocksInteractor())->getChildBlocks($blockID));
    }*/
}
