<?php

namespace CMS\Interactors\Areas;

use CMS\Repositories\AreaRepositoryInterface;
use CMS\Structures\AreaStructure;

class GetAreasInteractor
{
    public function __construct(AreaRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll($pageID, $structure = false)
    {
        $areas = $this->repository->findByPageID($pageID);

        return ($structure) ? $this->getAreaStructures($areas) : $areas;
    }

    private function getAreaStructures($areas)
    {
        $areaStructures = [];
        if (is_array($areas) && sizeof($areas) > 0) {
            foreach ($areas as $area) {
                $areaStructures[] = AreaStructure::toStructure($area);
            }
        }

        return $areaStructures;
    }
}
