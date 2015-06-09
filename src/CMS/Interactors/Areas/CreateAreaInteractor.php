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
        $area = new Area();
        $area->setInfos($areaStructure);
        $area->valid();

        $areaID = Context::getRepository('area')->createArea($area);

        if ($area->getIsMaster()) {
            $this->createAreaInChildPages($areaStructure, $areaID, $area->getPageID());
        }

        return $areaID;
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
