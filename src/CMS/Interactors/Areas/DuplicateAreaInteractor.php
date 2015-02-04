<?php

namespace CMS\Interactors\Areas;

use CMS\Structures\AreaStructure;

class DuplicateAreaInteractor
{
    private $createAreaInteractor;

    public function __construct(CreateAreaInteractor $createAreaInteractor)
    {
        $this->createAreaInteractor = $createAreaInteractor;
    }

    public function run(AreaStructure $areaStructure, $newPageID)
    {
        $areaStructure->ID = null;
        $areaStructure->page_id = $newPageID;

        return $this->createAreaInteractor->run($areaStructure);
    }
} 