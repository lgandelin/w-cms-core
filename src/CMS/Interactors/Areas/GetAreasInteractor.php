<?php

namespace CMS\Interactors\Areas;

use CMS\Context;
use CMS\Structures\AreaStructure;

class GetAreasInteractor
{
    public function getAll($pageID, $structure = false)
    {
        $areas = Context::getRepository('area')->findByPageID($pageID);

        return ($structure) ? $this->getAreaStructures($areas) : $areas;
    }

    private function getAreaStructures($areas)
    {
        $areaStructures = [];
        if (is_array($areas) && sizeof($areas) > 0) {
            foreach ($areas as $area) {
                $areaStructures[] = AreaStructure::toStructure($area);
            }
        }

        return $areaStructures;
    }

    public function getChildAreas($masterAreaID, $structure = false)
    {
        $areas = Context::getRepository('area')->findChildAreas($masterAreaID);

        return ($structure) ? $this->getAreaStructures($areas) : $areas;
    }
}
