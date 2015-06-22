<?php

namespace CMS\Interactors\Areas;

use CMS\Context;
use CMS\DataStructure;

class UpdateAreaInteractor extends GetAreaInteractor
{
    public function run($areaID, DataStructure $areaStructure)
    {
        $area = $this->getAreaByID($areaID);
        $area->setInfos($areaStructure);
        $area->valid();

        Context::getRepository('area')->updateArea($area);

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
