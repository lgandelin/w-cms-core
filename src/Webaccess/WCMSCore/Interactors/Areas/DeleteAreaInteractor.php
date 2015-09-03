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
            Context::get('area')->deleteArea($areaID);

            if ($this->eventManager) {
                $this->eventManager->fireEvent(new DeleteAreaEvent($area));
            }
        }
    }

    private function deleteBlocks($areaID)
    {
        $blocks = (new GetBlocksInteractor())->getAllByAreaID($areaID);

        if (is_array($blocks) && sizeof($blocks) > 0) {
            foreach ($blocks as $block) {
                (new DeleteBlockInteractor())->run($block->getID());
            }
        }
    }

    private function deleteChildAreas($areaID)
    {
        $childAreas = (new GetAreasInteractor())->getChildAreas($areaID);

        if (is_array($childAreas) && sizeof($childAreas) > 0) {
            foreach ($childAreas as $childArea) {
                $this->run($childArea->getID());
            }
        }
    }
}
