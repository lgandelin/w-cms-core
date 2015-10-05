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
        return array_map(function($area) {
            return $area->toStructure();
        }, $areas);
    }

    public function getChildAreas($masterAreaID, $structure = false)
    {
        $areas = Context::get('area_repository')->findChildAreas($masterAreaID);

        return ($structure) ? $this->getDataStructures($areas) : $areas;
    }
}
