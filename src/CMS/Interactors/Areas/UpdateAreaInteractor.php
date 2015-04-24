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

        $properties = get_object_vars($areaStructure);
        unset ($properties['ID']);
        foreach ($properties as $property => $value) {
            $method = ucfirst(str_replace('_', '', $property));
            $setter = 'set' . $method;

            if ($areaStructure->$property !== null) {
                call_user_func_array(array($area, $setter), array($value));
            }
        }

        $area->valid();

        $this->repository->updateArea($area);

        if ($area->getIsMaster()) {
            $areaStructure->is_master = 0;
            $this->updateChildAreas($areaID, $areaStructure);
        }
    }

    private function updateChildAreas($areaID, AreaStructure $areaStructure)
    {
        $childAreas = $this->getAreasInteractor->getChildAreas($areaID);

        if (is_array($childAreas) && sizeof($childAreas) > 0) {
            foreach ($childAreas as $child) {
                $this->run($child->getID(), $areaStructure);
            }
        }
    }
}
