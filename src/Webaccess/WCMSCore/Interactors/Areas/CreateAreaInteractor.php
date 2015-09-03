<?php

namespace Webaccess\WCMSCore\Interactors\Areas;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Interactors\Pages\GetPagesInteractor;
use Webaccess\WCMSCore\DataStructure;

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
