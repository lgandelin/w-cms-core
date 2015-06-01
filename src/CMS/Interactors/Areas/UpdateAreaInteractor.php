<?php

namespace CMS\Interactors\Areas;

use CMS\Context;
use CMS\Structures\AreaStructure;

class UpdateAreaInteractor extends GetAreaInteractor
{
    public function run($areaID, AreaStructure $areaStructure)
    {
        $area = $this->getAreaByID($areaID);

        $properties = get_object_vars($areaStructure);
        unset ($properties['ID']);
        foreach ($properties as $property => $value) {
            $method = ucfirst(str_replace('_', '', $property));
            $setter = 'set' . $method;

            if ($areaStructure->$property !== null) {
                call_user_func_array(array($area, $setter), array($value));
            }
        }

        $area->valid();

        Context::$areaRepository->updateArea($area);

        if ($area->getIsMaster()) {
            $areaStructure->is_master = 0;
            $this->updateChildAreas($areaID, $areaStructure);
        }
    }

    private function updateChildAreas($areaID, AreaStructure $areaStructure)
    {
        $childAreas = (new GetAreasInteractor())->getChildAreas($areaID);

        if (is_array($childAreas) && sizeof($childAreas) > 0) {
            foreach ($childAreas as $child) {
                $this->run($child->getID(), $areaStructure);
            }
        }
    }
}
