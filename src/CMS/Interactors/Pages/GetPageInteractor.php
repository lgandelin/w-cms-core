<?php

namespace CMS\Interactors\Pages;

use CMS\Context;
use CMS\Structures\PageStructure;

class GetPageInteractor
{
    public function getPageByID($pageID, $structure = false)
    {
        if (!$page = Context::$pageRepository->findByID($pageID)) {
            throw new \Exception('The page was not found');
        }

        return ($structure) ? PageStructure::toStructure($page) : $page;
    }

    public function getPageByURI($pageURI, $langID = null, $structure = false)
    {
        $page = ($langID) ? Context::$pageRepository->findByUriAndLangID($pageURI, $langID) : Context::$pageRepository->findByUri($pageURI);

        if (!$page) {
            throw new \Exception('The page was not found');
        }

        return ($structure) ? PageStructure::toStructure($page) : $page;
    }
}
