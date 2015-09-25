<?php

namespace Webaccess\WCMSCore\Interactors\Areas;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;

class UpdateAreaInteractor extends GetAreaInteractor
{
    public function run($areaID, DataStructure $areaStructure)
    {
        $area = $this->getAreaByID($areaID);
        $area->setInfos($areaStructure);
        $area->valid();

        Context::get('area_repository')->updateArea($area);

        if ($area->getIsMaster()) {
            $this->updateChildAreas($areaID, $areaStructure);
        }
    }

    private function updateChildAreas($areaID, DataStructure $areaStructure)
    {
        $areaStructure->is_master = 0;
        array_map(function($childArea) use ($areaStructure) {
            $this->run($childArea->getID(), $areaStructure);
        }, (new GetAreasInteractor())->getChildAreas($areaID));
    }
}
