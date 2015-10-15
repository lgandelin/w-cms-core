<?php

namespace Webaccess\WCMSCore\Interactors\Blocks;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Interactors\Areas\DuplicateAreaInteractor;
use Webaccess\WCMSCore\Interactors\Areas\GetAreasInteractor;
use Webaccess\WCMSCore\Interactors\Pages\GetPageInteractor;

class UpdateBlockInteractor extends GetBlockInteractor
{
    public function run($blockID, DataStructure $blockStructure)
    {
        if ($block = $this->getBlockByID($blockID)) {

            if ($page = (new GetPageInteractor)->getPageFromBlockID($block->getID())) {
                if ($page->isNewVersionNeeded()) {
                    $pageID = $page->getID();
                    $newPageVersion = $page->getDraftVersionNumber() + 1;
                    $this->updatePageVersion($page, $newPageVersion);

                    array_map(function($area) use ($newPageVersion, $pageID, $blockStructure, $blockID) {
                        $newAreaStructure = $area->toStructure();
                        $newAreaStructure->version_number = $newPageVersion;
                        $newAreaID = (new DuplicateAreaInteractor())->run($newAreaStructure, $pageID);

                        $blocks =  (new GetBlocksInteractor())->getAllByAreaID($area->getID());

                        foreach ($blocks as $block) {
                            $block->setVersionNumber($newPageVersion);
                            $newBlockID = (new DuplicateBlockInteractor())->run(clone $block, $newAreaID);

                            //Update block
                            if ($block->getID() == $blockID) {
                                $newBlock = (new GetBlockInteractor())->getBlockByID($newBlockID);
                                $newBlock->setInfos($blockStructure);
                                $newBlock->setID($newBlockID);
                                $newBlock->setVersionNumber($newPageVersion);
                                $newBlock->setAreaID($newAreaID);

                                Context::get('block_repository')->updateBlock($newBlock);
                            }
                        }

                    }, (new GetAreasInteractor())->getByPageIDAndVersionNumber($page->getID(), $page->getVersionNumber()));
                } else {
                    $this->updateExistingBlockVersion($blockStructure, $block);
                }

                if ($block->getIsMaster()) {
                    $this->updateChildBlocks($blockStructure, $block->getID());
                }
            }
        }
    }

    private function updateExistingBlockVersion(DataStructure $blockStructure, $block)
    {
        if (!$block->getIsGhost()) {
            $block->setInfos($blockStructure);
            Context::get('block_repository')->updateBlock($block);
        }
    }

    private function updateChildBlocks(DataStructure $blockStructure, $blockID)
    {
        unset($blockStructure->area_id);
        unset($blockStructure->is_master);
        array_map(function($childBlock) use ($blockStructure) {
            $this->run($childBlock->getID(), $blockStructure);
        }, (new GetBlocksInteractor())->getChildBlocks($blockID));
    }

    private function updatePageVersion($page, $newPageVersion)
    {
        $page->setDraftVersionNumber($newPageVersion);
        Context::get('page_repository')->updatePage($page);
    }
}
