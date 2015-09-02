<?php

namespace Webaccess\WCMSCore\Interactors\Pages;

use Webaccess\WCMSCore\Context;

class GetPageInteractor
{
    public function getPageByID($pageID, $structure = false)
    {
        if (!$page = Context::get('page')->findByID($pageID)) {
            throw new \Exception('The page was not found');
        }

        return ($structure) ? $page->toStructure() : $page;
    }

    public function getPageByURI($pageURI, $langID = null, $structure = false)
    {
        $page = ($langID) ? Context::get('page')->findByUriAndLangID($pageURI, $langID) : Context::get('page')->findByUri($pageURI);

        if (!$page) {
            throw new \Exception('The page was not found');
        }

        return ($structure) ? $page->toStructure() : $page;
    }
}
