<?php

namespace Webaccess\WCMSCore\Interactors\Areas;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Events\DeleteAreaEvent;
use Webaccess\WCMSCore\Interactors\Blocks\DeleteBlockInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlocksInteractor;

class DeleteAreaInteractor extends GetAreaInteractor
{
    public function run($areaID)
    {
        if ($area = $this->getAreaByID($areaID)) {

            if ($area->getIsMaster()) {
                $this->deleteChildAreas($areaID);
            }
            $this->deleteBlocks($areaID);
            Context::get('area_repository')->deleteArea($areaID);

            if ($this->eventManager) {
                $this->eventManager->fireEvent(new DeleteAreaEvent($area));
            }
        }
    }

    private function deleteBlocks($areaID)
    {
        array_map(function($block) {
            (new DeleteBlockInteractor())->run($block->getID());
        }, (new GetBlocksInteractor())->getAllByAreaID($areaID));
    }

    private function deleteChildAreas($areaID)
    {
        array_map(function($childArea) {
            $this->run($childArea->getID());
        }, (new GetAreasInteractor())->getChildAreas($areaID));
    }
}
