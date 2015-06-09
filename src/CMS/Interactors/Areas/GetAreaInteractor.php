<?php

namespace CMS\Interactors\Areas;

use CMS\Context;
use CMS\Interactors\Interactor;
use CMS\Structures\AreaStructure;

class GetAreaInteractor extends Interactor
{
    public function getAreaByID($areaID, $structure = false)
    {
        if (!$area = Context::getRepository('area')->findByID($areaID)) {
            throw new \Exception('The area was not found');
        }

        return ($structure) ? AreaStructure::toStructure($area) : $area;
    }
}
