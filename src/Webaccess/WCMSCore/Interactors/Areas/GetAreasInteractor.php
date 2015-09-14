<?php

namespace Webaccess\WCMSCore\Interactors\Areas;

use Webaccess\WCMSCore\Context;

class GetAreasInteractor
{
    public function getAll($pageID, $structure = false)
    {
        $areas = Context::get('area_repository')->findByPageID($pageID);

        return ($structure) ? $this->getDataStructures($areas) : $areas;
    }

    private function getDataStructures($areas)
    {
        $areaStructures = [];
        if (is_array($areas) && sizeof($areas) > 0) {
            foreach ($areas as $area) {
                $areaStructures[] = $area->toStructure();
            }
        }

        return $areaStructures;
    }

    public function getChildAreas($masterAreaID, $structure = false)
    {
        $areas = Context::get('area_repository')->findChildAreas($masterAreaID);

        return ($structure) ? $this->getDataStructures($areas) : $areas;
    }
}
