<?php

namespace CMS\Interactors\Areas;

use CMS\Context;
use CMS\Interactors\Interactor;

class GetAreaInteractor extends Interactor
{
    public function getAreaByID($areaID, $structure = false)
    {
        if (!$area = Context::get('area')->findByID($areaID)) {
            throw new \Exception('The area was not found');
        }

        return ($structure) ? $area->toStructure() : $area;
    }
}
