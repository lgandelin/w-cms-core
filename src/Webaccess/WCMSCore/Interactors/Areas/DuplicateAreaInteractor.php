<?php

namespace Webaccess\WCMSCore\Interactors\Areas;

use Webaccess\WCMSCore\DataStructure;

class DuplicateAreaInteractor
{
    public function run(DataStructure $areaStructure, $newPageID)
    {
        $areaStructure->ID = null;
        $areaStructure->pageID = $newPageID;

        return (new CreateAreaInteractor())->run($areaStructure, false);
    }
}
