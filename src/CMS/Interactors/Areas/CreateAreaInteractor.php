<?php

namespace CMS\Interactors\Areas;

use CMS\Entities\Area;
use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Repositories\AreaRepositoryInterface;
use CMS\Repositories\PageRepositoryInterface;
use CMS\Structures\AreaStructure;

class CreateAreaInteractor extends GetPageInteractor {

    public function __construct(AreaRepositoryInterface $repository, PageRepositoryInterface $pageRepository)
    {
        $this->repository = $repository;
        $this->pageRepository = $pageRepository;
    }

    public function run(AreaStructure $areaStructure)
    {
        if ($this->getPageByID($areaStructure->page_id)) {
            $area = new Area();

            if ($areaStructure->name !== null) $area->setName($areaStructure->name);
            if ($areaStructure->width !== null) $area->setWidth($areaStructure->width);
            if ($areaStructure->height !== null) $area->setHeight($areaStructure->height);
            if ($areaStructure->class !== null) $area->setClass($areaStructure->class);
            if ($areaStructure->order !== null) $area->setOrder($areaStructure->order);
            if ($areaStructure->page_id !== null) $area->setPageID($areaStructure->page_id);
            if ($areaStructure->display !== null) $area->setDisplay($areaStructure->display);

            if ($area->valid())
                return $this->repository->createArea($area);
        }
    }
}