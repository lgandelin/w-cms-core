<?php

namespace CMS\Interactors\Areas;

use CMS\Structures\AreaStructure;

class UpdateAreaInteractor extends GetAreaInteractor
{
    public function run($areaID, AreaStructure $areaStructure)
    {
        $area = $this->getAreaByID($areaID);

        if ($areaStructure->name !== null && $areaStructure->name != $area->getName()) $area->setName($areaStructure->name);
        if ($areaStructure->width !== null && $areaStructure->width != $area->getWidth()) $area->setWidth($areaStructure->width);
        if ($areaStructure->height !== null && $areaStructure->height != $area->getHeight()) $area->setHeight($areaStructure->height);
        if ($areaStructure->class !== null && $areaStructure->class != $area->getClass()) $area->setClass($areaStructure->class);
        if ($areaStructure->order !== null && $areaStructure->order != $area->getOrder()) $area->setOrder($areaStructure->order);
        if ($areaStructure->display !== null && $areaStructure->display != $area->getDisplay()) $area->setDisplay($areaStructure->display);

        $area->valid();

        $this->repository->updateArea($area);
    }
}