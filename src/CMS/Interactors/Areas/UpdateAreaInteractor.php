<?php

namespace CMS\Interactors\Areas;

use CMS\Repositories\AreaRepositoryInterface;
use CMS\Structures\AreaStructure;

class UpdateAreaInteractor extends GetAreaInteractor
{
    protected $repository;
    private $getAreasInteractor;

    public function __construct(AreaRepositoryInterface $repository, GetAreasInteractor $getAreasInteractor)
    {
        $this->repository = $repository;
        $this->getAreasInteractor = $getAreasInteractor;
    }

    public function run($areaID, AreaStructure $areaStructure)
    {
        $area = $this->getAreaByID($areaID);

        if ($areaStructure->name !== null && $areaStructure->name != $area->getName()) {
            $area->setName($areaStructure->name);
        }

        if ($areaStructure->width !== null && $areaStructure->width != $area->getWidth()) {
            $area->setWidth($areaStructure->width);
        }

        if ($areaStructure->height !== null && $areaStructure->height != $area->getHeight()) {
            $area->setHeight($areaStructure->height);
        }

        if ($areaStructure->class !== null && $areaStructure->class != $area->getClass()) {
            $area->setClass($areaStructure->class);
        }

        if ($areaStructure->order !== null && $areaStructure->order != $area->getOrder()) {
            $area->setOrder($areaStructure->order);
        }

        if ($areaStructure->display !== null && $areaStructure->display != $area->getDisplay()) {
            $area->setDisplay($areaStructure->display);
        }

        if ($areaStructure->master_area_id !== null && $areaStructure->master_area_id != $area->getMasterAreaID()) {
            $area->setMasterAreaID($areaStructure->master_area_id);
        }

        if (isset($areaStructure->is_master) && $areaStructure->is_master !== null && $areaStructure->is_master != $area->getIsMaster()) {
            $area->setIsMaster($areaStructure->is_master);
        }

        $area->valid();

        $this->repository->updateArea($area);

        if ($area->getIsMaster()) {
            $areaStructure->is_master = 0;
            $this->updateChildAreas($areaStructure, $areaID);
        }
    }

    private function updateChildAreas(AreaStructure $areaStructure, $areaID)
    {
        $childAreas = $this->getAreasInteractor->getChildAreas($areaID);

        if (is_array($childAreas) && sizeof($childAreas) > 0) {
            foreach ($childAreas as $child) {
                $this->run($child->getID(), $areaStructure);
            }
        }
    }
}
