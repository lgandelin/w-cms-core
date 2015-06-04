<?php

namespace CMS\Interactors\Areas;

use CMS\Structures\AreaStructure;

class DuplicateAreaInteractor
{
    public function run(AreaStructure $areaStructure, $newPageID)
    {
        $areaStructure->ID = null;
        $areaStructure->page_id = $newPageID;

        return (new CreateAreaInteractor())->run($areaStructure);
    }
}
