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

        Context::get('area')->updateArea($area);

        if ($area->getIsMaster()) {
            $this->updateChildAreas($areaID, $areaStructure);
        }
    }

    private function updateChildAreas($areaID, DataStructure $areaStructure)
    {
        $areaStructure->is_master = 0;
        $childAreas = (new GetAreasInteractor())->getChildAreas($areaID);

        if (is_array($childAreas) && sizeof($childAreas) > 0) {
            foreach ($childAreas as $child) {
                $this->run($child->getID(), $areaStructure);
            }
        }
    }
}
