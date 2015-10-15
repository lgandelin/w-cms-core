<?php

namespace Webaccess\WCMSCore\Interactors\Versions;

use Webaccess\WCMSCore\Interactors\Areas\DeleteAreaInteractor;
use Webaccess\WCMSCore\Interactors\Areas\GetAreasInteractor;

class DeletePageVersionInteractor
{
    public function run($pageID, $versionNumber)
    {
        array_map(function($area) {
            (new DeleteAreaInteractor())->run($area->getID());
        }, (new GetAreasInteractor())->getByPageIDAndVersionNumber($pageID, $versionNumber));
    }
} 