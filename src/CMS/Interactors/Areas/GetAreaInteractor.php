<?php

namespace CMS\Interactors\Areas;

use CMS\Repositories\AreaRepositoryInterface;
use CMS\Structures\AreaStructure;

class GetAreaInteractor
{
    protected $repository;

    public function __construct(AreaRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getByID($areaID)
    {
        if (!$area = $this->repository->findByID($areaID))
            throw new \Exception('The area was not found');

        $areaStructure = new AreaStructure();
        $areaStructure->ID = $area->getID();
        $areaStructure->name = $area->getName();
        $areaStructure->width = $area->getWidth();
        $areaStructure->height = $area->getHeight();
        $areaStructure->class = $area->getClass();
        $areaStructure->page_id = $area->getPageID();

        return $areaStructure;
    }

}