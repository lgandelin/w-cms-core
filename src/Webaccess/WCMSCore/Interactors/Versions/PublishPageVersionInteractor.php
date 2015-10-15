<?php

namespace Webaccess\WCMSCore\Interactors\Versions;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Pages\GetPageInteractor;

class PublishPageVersionInteractor
{
    public function run($pageID, $versionNumber)
    {
        if ($page = (new GetPageInteractor())->getPageByID($pageID)) {
            $page->setVersionNumber($versionNumber);
            Context::get('page_repository')->updatePage($page);
        }
    }
} 