<?php

namespace CMS\Interactors\Areas;

use CMS\Structures\DataStructure;

class DuplicateAreaInteractor
{
    public function run(DataStructure $areaStructure, $newPageID)
    {
        $areaStructure->ID = null;
        $areaStructure->page_id = $newPageID;

        return (new CreateAreaInteractor())->run($areaStructure);
    }
}
