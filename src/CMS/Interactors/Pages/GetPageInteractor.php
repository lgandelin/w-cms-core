<?php

namespace CMS\Interactors\Pages;

use CMS\Context;

class GetPageInteractor
{
    public function getPageByID($pageID, $structure = false)
    {
        if (!$page = Context::getRepository('page')->findByID($pageID)) {
            throw new \Exception('The page was not found');
        }

        return ($structure) ? $page->toStructure() : $page;
    }

    public function getPageByURI($pageURI, $langID = null, $structure = false)
    {
        $page = ($langID) ? Context::getRepository('page')->findByUriAndLangID($pageURI, $langID) : Context::getRepository('page')->findByUri($pageURI);

        if (!$page) {
            throw new \Exception('The page was not found');
        }

        return ($structure) ? $page->toStructure() : $page;
    }
}
