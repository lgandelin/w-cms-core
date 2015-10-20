<?php

namespace Webaccess\WCMSCore\Interactors\Versions;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Areas\DeleteAreaInteractor;
use Webaccess\WCMSCore\Interactors\Areas\GetAreasInteractor;
use Webaccess\WCMSCore\Interactors\Pages\GetPageInteractor;

class DeletePageVersionInteractor
{
    public function run($pageID, $versionID)
    {
        $page = (new GetPageInteractor())->getPageByID($pageID);
        $page->setDraftVersionID($page->getVersionID());
        Context::get('page_repository')->updatePage($page);

        $version = Context::get('version_repository')->findByID($versionID);
        array_map(function($area) {
            (new DeleteAreaInteractor())->run($area->getID());
        }, (new GetAreasInteractor())->getByPageIDAndVersionNumber($pageID, $version->getNumber()));

        Context::get('version_repository')->deleteVersion($versionID);
    }
} 