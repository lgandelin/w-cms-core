<?php

namespace Webaccess\WCMSCore\Interactors\Blocks;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Entities\Version;
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
                    $this->createNewPageVersion($blockID, $blockStructure, $page);
                } else {
                    $this->updateExistingBlockVersion($blockStructure, $block);
                }

                /*if ($block->getIsMaster()) {
                    $this->updateChildBlocks($blockStructure, $block->getID());
                }*/
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

    private function createNewPageVersion($blockID, DataStructure $blockStructure, $page)
    {
        $version = false;
        $currentVersion = Context::get('version_repository')->findByID($page->getVersionID());
        if ($currentVersion) {
            $version = new Version();
            $version->setPageID($page->getID());
            $version->setNumber($currentVersion->getNumber() + 1);
            $versionID = Context::get('version_repository')->createVersion($version);

            $page->setDraftVersionID($versionID);
            Context::get('page_repository')->updatePage($page);
        }

        if ($currentVersion && $version) {
            array_map(function ($area) use ($version, $page, $blockStructure, $blockID) {
                $newAreaStructure = $area->toStructure();
                $newAreaStructure->version_number = $version->getNumber();
                $newAreaID = (new DuplicateAreaInteractor())->run($newAreaStructure, $page->getID());
                array_map(function ($block) use ($version, $newAreaID, $blockStructure, $blockID) {
                    $newBlockID = (new DuplicateBlockInteractor())->run($block, $newAreaID, $version->getNumber());

                    //Update block with last modifications
                    if ($block->getID() == $blockID) {
                        $newBlock = (new GetBlockInteractor())->getBlockByID($newBlockID);
                        $newBlock->setInfos($blockStructure);
                        $newBlock->setID($newBlockID);
                        $newBlock->setVersionNumber($version->getNumber());
                        $newBlock->setAreaID($newAreaID);

                        Context::get('block_repository')->updateBlock($newBlock);
                    }
                }, (new GetBlocksInteractor())->getAllByAreaID($area->getID()));
            }, (new GetAreasInteractor())->getByPageIDAndVersionNumber($page->getID(), $currentVersion->getNumber()));
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
