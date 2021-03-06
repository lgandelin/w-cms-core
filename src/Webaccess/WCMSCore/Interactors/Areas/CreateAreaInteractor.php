<?php

namespace Webaccess\WCMSCore\Interactors\Areas;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Interactors\Pages\GetPageInteractor;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Interactors\Versions\CreatePageVersionInteractor;

class CreateAreaInteractor
{
    public function run(DataStructure $areaStructure, $newVersion = true)
    {
        $newPageVersion = false;
        $areaID = null;

        if ($page = (new GetPageInteractor())->getPageByID($areaStructure->pageID)) {
            if ($page->isNewVersionNeeded() && $newVersion) {

                $newPageVersion = true;
                list($newAreaID, $newBlockID, $versionNumber) = (new CreatePageVersionInteractor())->run($page);
                $areaStructure->versionNumber = $versionNumber;
            } else {
                $version = Context::get('version_repository')->findByID($page->getDraftVersionID());
                $areaStructure->versionNumber = $version->getNumber();
            }
        }
        $areaID = $this->createArea($areaStructure);

        return array($areaID, $newPageVersion);
    }

    /*private function createAreaInChildPages(DataStructure $areaStructure, $areaID, $pageID)
    {
        array_map(function($childPage) use ($areaStructure, $areaID) {
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
        }, (new GetPagesInteractor())->getChildPages($pageID));
    }*/

    private function createArea(DataStructure $areaStructure)
    {
        $area = (new Area())->setInfos($areaStructure);
        $area->valid();

        $areaID = Context::get('area_repository')->createArea($area);

        /*if ($area->getIsMaster()) {
            $this->createAreaInChildPages($areaStructure, $areaID, $area->getPageID());
        }*/

        return $areaID;
    }
}
