<?php

namespace Webaccess\WCMSCore\Interactors\Areas;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Entities\Version;
use Webaccess\WCMSCore\Interactors\Pages\GetPageInteractor;

class UpdateAreaInteractor extends GetAreaInteractor
{
    public function run($areaID, DataStructure $areaStructure)
    {
        if ($area = $this->getAreaByID($areaID)) {
            if ($page = (new GetPageInteractor)->getPageFromAreaID($area->getID())) {
                if ($page->isNewVersionNeeded()) {
                    $this->createNewPageVersion($areaID, $areaStructure, $page);
                } else {
                    $this->updateExistingAreaVersion($areaStructure, $area);
                }
            }
        }
    }

    private function updateChildAreas($areaID, DataStructure $areaStructure)
    {
        $areaStructure->is_master = 0;
        array_map(function($childArea) use ($areaStructure) {
            $this->run($childArea->getID(), $areaStructure);
        }, (new GetAreasInteractor())->getChildAreas($areaID));
    }

    private function createNewPageVersion($areaID, $areaStructure, $page)
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
            array_map(function ($area) use ($version, $page, $areaStructure, $areaID) {
                $newAreaStructure = $area->toStructure();
                $newAreaStructure->version_number = $version->getNumber();
                $newAreaID = (new DuplicateAreaInteractor())->run($newAreaStructure, $page->getID());

                if ($area->getID() == $areaID) {
                    $newArea = (new GetAreaInteractor())->getAreaByID($newAreaID);
                    $newArea->setInfos($areaStructure);
                    $newArea->setID($newAreaID);
                    $newArea->setVersionNumber($version->getNumber());

                    Context::get('area_repository')->updateArea($newArea);
                }

                /*array_map(function ($block) use ($version, $newAreaID, $blockStructure, $blockID) {
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
                }, (new GetBlocksInteractor())->getAllByAreaID($area->getID()));*/
            }, (new GetAreasInteractor())->getByPageIDAndVersionNumber($page->getID(), $currentVersion->getNumber()));
        }
    }

    private function updateExistingAreaVersion($areaStructure, $area)
    {
        $area->setInfos($areaStructure);
        $area->valid();

        Context::get('area_repository')->updateArea($area);

        if ($area->getIsMaster()) {
            $this->updateChildAreas($area->getID(), $areaStructure);
        }
    }
}
