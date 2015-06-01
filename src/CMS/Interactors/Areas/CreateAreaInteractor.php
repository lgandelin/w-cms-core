<?php

namespace CMS\Interactors\Areas;

use CMS\Context;
use CMS\Entities\Area;
use CMS\Interactors\Pages\GetPagesInteractor;
use CMS\Structures\AreaStructure;

class CreateAreaInteractor
{
    public function run(AreaStructure $areaStructure)
    {
        $area = $this->createAreaFromStructure($areaStructure);

        $area->valid();

        $areaID = Context::$areaRepository->createArea($area);

        if ($area->getIsMaster()) {
            $this->createAreaInChildPages($areaStructure, $areaID, $area->getPageID());
        }

        return $areaID;
    }

    private function createAreaFromStructure(AreaStructure $areaStructure)
    {
        $area = new Area();

        $properties = get_object_vars($areaStructure);
        foreach ($properties as $property => $value) {
            $method = ucfirst(str_replace('_', '', $property));
            $setter = 'set' . $method;

            if ($areaStructure->$property !== null) {
                call_user_func_array(array($area, $setter), array($value));
            }
        }

        return $area;
    }

    private function createAreaInChildPages(AreaStructure $areaStructure, $areaID, $pageID)
    {
        $childPages = (new GetPagesInteractor())->getChildPages($pageID);

        if (is_array($childPages) && sizeof($childPages) > 0) {
            foreach ($childPages as $childPage) {
                $areaStructure = new AreaStructure([
                    'name' => $areaStructure->name,
                    'page_id' => $childPage->getID(),
                    'master_area_id' => $areaID,
                    'width' => $areaStructure->width,
                    'height' => $areaStructure->height,
                    'order' => $areaStructure->order,
                    'display' => $areaStructure->display
                ]);
                $this->run($areaStructure);
            }
        }
    }
}
