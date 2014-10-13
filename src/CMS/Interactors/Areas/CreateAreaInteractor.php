<?php

namespace CMS\Interactors\Areas;

use CMS\Entities\Area;
use CMS\Repositories\AreaRepositoryInterface;
use CMS\Structures\AreaStructure;

class CreateAreaInteractor
{
    public function __construct(AreaRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(AreaStructure $areaStructure)
    {
        $area = $this->createAreaFromStructure($areaStructure);

        $area->valid();

        $this->repository->createArea($area);
    }

    private function createAreaFromStructure(AreaStructure $areaStructure)
    {
        $area = new Area();
        if ($areaStructure->name !== null) $area->setName($areaStructure->name);
        if ($areaStructure->width !== null) $area->setWidth($areaStructure->width);
        if ($areaStructure->height !== null) $area->setHeight($areaStructure->height);
        if ($areaStructure->class !== null) $area->setClass($areaStructure->class);
        if ($areaStructure->order !== null) $area->setOrder($areaStructure->order);
        if ($areaStructure->page_id !== null) $area->setPageID($areaStructure->page_id);
        if ($areaStructure->display !== null) $area->setDisplay($areaStructure->display);

        return $area;
    }
}