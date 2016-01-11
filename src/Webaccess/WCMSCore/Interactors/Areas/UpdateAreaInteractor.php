<?php

namespace Webaccess\WCMSCore\Interactors\Areas;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Interactors\Pages\GetPageInteractor;
use Webaccess\WCMSCore\Interactors\Versions\CreatePageVersionInteractor;

class UpdateAreaInteractor extends GetAreaInteractor
{
    public function run($areaID, DataStructure $areaStructure)
    {
        $newPageVersion = false;
        if ($area = $this->getAreaByID($areaID)) {
            if ($page = (new GetPageInteractor)->getPageFromAreaID($areaID)) {
                if ($page->isNewVersionNeeded()) {
                    $newPageVersion = true;
                    list($newAreaID, $newBlockID, $versionNumber) = (new CreatePageVersionInteractor())->run($page, $areaID);
                    $area = (new GetAreaInteractor())->getAreaByID($newAreaID);
                    $areaStructure->ID = $newAreaID;
                    $areaStructure->versionNumber = $versionNumber;
                }
                $this->updateArea($areaStructure, $area);
            }
        }

        return $newPageVersion;
    }

    private function updateArea($areaStructure, $area)
    {
        $area->setInfos($areaStructure);
        $area->valid();

        Context::get('area_repository')->updateArea($area);

        /*if ($area->getIsMaster()) {
            $this->updateChildAreas($area->getID(), $areaStructure);
        }*/
    }

    /*private function updateChildAreas($areaID, DataStructure $areaStructure)
    {
        $areaStructure->is_master = 0;
        array_map(function($childArea) use ($areaStructure) {
            $this->run($childArea->getID(), $areaStructure);
        }, (new GetAreasInteractor())->getChildAreas($areaID));
    }*/
}
