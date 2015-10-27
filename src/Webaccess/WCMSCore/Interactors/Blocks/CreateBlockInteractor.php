<?php

namespace Webaccess\WCMSCore\Interactors\Blocks;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Block;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Interactors\Pages\GetPageInteractor;
use Webaccess\WCMSCore\Interactors\Versions\CreatePageVersionInteractor;

class CreateBlockInteractor
{
    public function run(DataStructure $blockStructure, $newVersion = true)
    {
        $newPageVersion = false;
        $blockID = null;

        if ($page = (new GetPageInteractor())->getPageFromAreaID($blockStructure->areaID)) {
            if ($page->isNewVersionNeeded() && $newVersion) {

                $newPageVersion = true;
                list($newAreaID, $newBlockID, $versionNumber) = (new CreatePageVersionInteractor())->run($page);
                $blockStructure->versionNumber = $versionNumber;
            } else {
                $version = Context::get('version_repository')->findByID($page->getDraftVersionID());
                $blockStructure->versionNumber = $version->getNumber();
            }
        }
        $blockID = $this->createBlock($blockStructure);

        return array($blockID, $newPageVersion);
    }

    private function createBlock($blockStructure)
    {
        $block = new Block();
        $block->setInfos($blockStructure);
        $block->valid();

        $blockID = Context::get('block_repository')->createBlock($block);

        /*if ($block->getIsMaster()) {
            $this->createBlockInChildAreas($blockStructure, $blockID, $block->getAreaID());
        }*/

        return $blockID;
    }

    /*private function createBlockInChildAreas($blockStructure, $blockID, $areaID)
    {
        array_map(function($childArea) use ($blockStructure, $blockID) {
            $childDataStructure = clone $blockStructure;
            $childDataStructure->area_id = $childArea->getID();
            $childDataStructure->master_block_id = $blockID;

            $this->run($childDataStructure);
        }, (new GetAreasInteractor())->getChildAreas($areaID));
    }*/
}
