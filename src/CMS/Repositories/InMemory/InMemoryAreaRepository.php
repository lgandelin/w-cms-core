<?php

namespace CMS\Repositories\InMemory;

use CMS\Entities\Area;
use CMS\Repositories\AreaRepositoryInterface;

class InMemoryAreaRepository implements AreaRepositoryInterface
{
    private $areas;

    public function __construct()
    {
        $this->areas = [];
    }

    public function findByID($areaID)
    {
        foreach ($this->areas as $area) {
            if ($area->getID() == $areaID) {
                return $area;
            }
        }

        return false;
    }

    public function findAll()
    {
        return $this->areas;
    }

    public function findChildAreas($areaID)
    {
        $areas = array();
        foreach ($this->areas as $area) {
            if ($area->getMasterAreaID() == $areaID)
                $areas[]= $area;
        }

        return $areas;
    }

    public function findByPageID($pageID)
    {
        $areas = array();
        foreach ($this->areas as $area) {
            if ($area->getPageID() == $pageID) {
                $areas[]= $area;
            }
        }

        return $areas;
    }

    public function createArea(Area $area)
    {
        $areaID = sizeof($this->areas) + 1;
        $area->setID($areaID);
        $this->areas[]= $area;

        return $areaID;
    }

    public function updateArea(Area $area)
    {
        foreach ($this->areas as $areaModel) {
            if ($areaModel->getID() == $area->getID()) {
                $areaModel->setName($area->getName());
                $areaModel->setWidth($area->getWidth());
                $areaModel->setHeight($area->getHeight());
                $areaModel->setClass($area->getClass());
                $areaModel->setOrder($area->getOrder());
                $areaModel->setDisplay($area->getDisplay());
                $areaModel->setIsMaster($area->getIsMaster());
            }
        }
    }

    public function deleteArea($areaID)
    {
        foreach ($this->areas as $i => $area) {
            if ($area->getID() == $areaID) {
                unset($this->areas[$i]);
            }
        }
    }
}
