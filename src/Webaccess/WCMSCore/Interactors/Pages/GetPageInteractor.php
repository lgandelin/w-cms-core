<?php

namespace Webaccess\WCMSCore\Interactors\Pages;

use Webaccess\WCMSCore\Context;

class GetPageInteractor
{
    public function getPageByID($pageID, $structure = false)
    {
        if (!$page = Context::get('page_repository')->findByID($pageID)) {
            throw new \Exception('The page was not found');
        }

        return ($structure) ? $page->toStructure() : $page;
    }

    public function getPageByURI($pageURI, $langID = null, $structure = false)
    {
        $page = ($langID) ? Context::get('page_repository')->findByUriAndLangID($pageURI, $langID) : Context::get('page_repository')->findByUri($pageURI);

        if (!$page) {
            throw new \Exception('The page was not found : ' . $pageURI);
        }

        return ($structure) ? $page->toStructure() : $page;
    }
}
