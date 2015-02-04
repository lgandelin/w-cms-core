<?php

namespace CMS\Interactors\Areas;

use CMS\Entities\Area;
use CMS\Interactors\Pages\GetPagesInteractor;
use CMS\Repositories\AreaRepositoryInterface;
use CMS\Structures\AreaStructure;

class CreateAreaInteractor
{
    public function __construct(AreaRepositoryInterface $repository, GetPagesInteractor $getPagesInteractor)
    {
        $this->repository = $repository;
        $this->getPagesInteractor = $getPagesInteractor;
    }

    public function run(AreaStructure $areaStructure)
    {
        $area = $this->createAreaFromStructure($areaStructure);

        $area->valid();

        $areaID = $this->repository->createArea($area);

        if ($area->getIsMaster()) {
            $this->createAreaInChildPages($areaStructure, $areaID, $area->getPageID());
        }

        return $areaID;
    }

    private function createAreaFromStructure(AreaStructure $areaStructure)
    {
        $area = new Area();

        if ($areaStructure->name !== null) {
            $area->setName($areaStructure->name);
        }

        if ($areaStructure->width !== null) {
            $area->setWidth($areaStructure->width);
        }

        if ($areaStructure->height !== null) {
            $area->setHeight($areaStructure->height);
        }

        if ($areaStructure->class !== null) {
            $area->setClass($areaStructure->class);
        }

        if ($areaStructure->order !== null) {
            $area->setOrder($areaStructure->order);
        }

        if ($areaStructure->page_id !== null) {
            $area->setPageID($areaStructure->page_id);
        }

        if ($areaStructure->display !== null) {
            $area->setDisplay($areaStructure->display);
        }

        if ($areaStructure->is_master !== null) {
            $area->setIsMaster($areaStructure->is_master);
        }

        if ($areaStructure->master_area_id !== null) {
            $area->setMasterAreaID($areaStructure->master_area_id);
        }

        return $area;
    }

    private function createAreaInChildPages(AreaStructure $areaStructure, $areaID, $pageID)
    {
        $childPages = $this->getPagesInteractor->getChildPages($pageID);

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
