<?php

namespace CMS\Interactors\Areas;

use CMS\Context;
use CMS\Structures\AreaStructure;

class UpdateAreaInteractor extends GetAreaInteractor
{
    public function run($areaID, AreaStructure $areaStructure)
    {
        $area = $this->getAreaByID($areaID);
        $area->setInfos($areaStructure);
        $area->valid();

        Context::$areaRepository->updateArea($area);

        if ($area->getIsMaster()) {
            $this->updateChildAreas($areaID, $areaStructure);
        }
    }

    private function updateChildAreas($areaID, AreaStructure $areaStructure)
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
