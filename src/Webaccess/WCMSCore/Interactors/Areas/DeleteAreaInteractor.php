<?php

namespace Webaccess\WCMSCore\Interactors\Areas;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Events\DeleteAreaEvent;
use Webaccess\WCMSCore\Interactors\Blocks\DeleteBlockInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlocksInteractor;
use Webaccess\WCMSCore\Interactors\Pages\GetPageInteractor;
use Webaccess\WCMSCore\Interactors\Versions\CreatePageVersionInteractor;

class DeleteAreaInteractor extends GetAreaInteractor
{
    public function run($areaID, $newVersion = true)
    {
        $newPageVersion = false;
        if ($area = $this->getAreaByID($areaID)) {

            if ($area->getIsMaster()) {
                $this->deleteChildAreas($areaID);
            }

            if ($page = (new GetPageInteractor)->getPageFromAreaID($area->getID())) {
                if ($page->isNewVersionNeeded() && $newVersion) {
                    $newPageVersion = true;
                    list($newAreaID, $newBlockID) = (new CreatePageVersionInteractor())->run($page, $areaID);
                    $area = (new GetAreaInteractor())->getAreaByID($newAreaID);
                }
                $this->deleteArea($area->getID());
            }

            if ($this->eventManager) {
                $this->eventManager->fireEvent(new DeleteAreaEvent($area));
            }
        }

        return $newPageVersion;
    }

    private function deleteArea($areaID)
    {
        $this->deleteBlocks($areaID);
        Context::get('area_repository')->deleteArea($areaID);
    }

    private function deleteBlocks($areaID)
    {
        array_map(function($block) {
            (new DeleteBlockInteractor())->run($block->getID(), false);
        }, (new GetBlocksInteractor())->getAllByAreaID($areaID));
    }

    private function deleteChildAreas($areaID)
    {
        array_map(function($childArea) {
            $this->run($childArea->getID());
        }, (new GetAreasInteractor())->getChildAreas($areaID));
    }
}
