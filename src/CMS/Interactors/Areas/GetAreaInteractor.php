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

    public function getAreaByID($areaID, $structure = false)
    {
        if (!$area = $this->repository->findByID($areaID))
            throw new \Exception('The area was not found');

        return ($structure) ? AreaStructure::toStructure($area) : $area;
    }
}