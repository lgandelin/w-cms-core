<?php

namespace CMS\Interactors\Areas;

use CMS\Context;
use CMS\Entities\Area;
use CMS\Interactors\Pages\GetPagesInteractor;
use CMS\DataStructure;

class CreateAreaInteractor
{
    public function run(DataStructure $areaStructure)
    {
        $area = new Area();
        $area->setInfos($areaStructure);
        $area->valid();

        $areaID = Context::get('area')->createArea($area);

        if ($area->getIsMaster()) {
            $this->createAreaInChildPages($areaStructure, $areaID, $area->getPageID());
        }

        return $areaID;
    }

    private function createAreaInChildPages(DataStructure $areaStructure, $areaID, $pageID)
    {
        $childPages = (new GetPagesInteractor())->getChildPages($pageID);

        if (is_array($childPages) && sizeof($childPages) > 0) {
            foreach ($childPages as $childPage) {
                $areaStructure = new DataStructure([
                    'name' => $areaStructure->name,
                    'page_id' => $childPage->getID(),
                    'masterAreaID' => $areaID,
                    'width' => isset($areaStructure->width) ? $areaStructure->width : 0,
                    'height' => isset($areaStructure->order) ? $areaStructure->order : 0,
                    'order' => isset($areaStructure->order) ? $areaStructure->order : 0,
                    'display' => isset($areaStructure->display) ? $areaStructure->display : 0
                ]);
                $this->run($areaStructure);
            }
        }
    }
}
