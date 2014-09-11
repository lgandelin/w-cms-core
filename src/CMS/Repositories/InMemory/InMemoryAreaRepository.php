<?php

namespace CMS\Repositories\InMemory;

use CMS\Repositories\AreaRepositoryInterface;
use CMS\Structures\AreaStructure;

class InMemoryAreaRepository implements AreaRepositoryInterface {

    private $areas;

    public function __construct()
    {
        $this->areas = [];
    }

    public function findByID($areaID)
    {
        foreach ($this->areas as $area) {
            if ($area->ID == $areaID)
                return $area;
        }

        return false;
    }

    public function findAll()
    {
        return $this->areas;
    }

    public function findByPageID($pageID)
    {
        $areas = array();
        foreach ($this->areas as $area) {
            if ($area->page_id == $pageID) {
                $areas[]= $area;
            }
        }
        return $areas;
    }

    public function createArea(AreaStructure $areaStructure)
    {
        $this->areas[]= $areaStructure;
    }

    public function updateArea($areaID, AreaStructure $areaStructure)
    {
        foreach ($this->areas as $area) {
            if ($area->ID == $areaID) {
                $area->name = $areaStructure->name;
                $area->width = $areaStructure->width;
                $area->height = $areaStructure->height;
                $area->class = $areaStructure->class;
            }
        }
    }

    public function deleteArea($areaID)
    {
        foreach ($this->areas as $i => $area) {
            if ($area->ID == $areaID) {
                unset($this->areas[$i]);
            }
        }
    }
} 