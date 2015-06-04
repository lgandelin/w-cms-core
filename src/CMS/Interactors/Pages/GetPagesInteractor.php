<?php

namespace CMS\Interactors\Pages;

use CMS\Context;
use CMS\Structures\PageStructure;

class GetPagesInteractor
{
    public function getAll($langID = null, $structure = false)
    {
        $pages = Context::$pageRepository->findAll($langID);

        return ($structure) ? $this->getPageStructures($pages) : $pages;
    }

    public function getMasterPages($structure = false)
    {
        $pages = Context::$pageRepository->findMasterPages();

        return ($structure) ? $this->getPageStructures($pages) : $pages;
    }

    public function getChildPages($pageID, $structure = false)
    {
        $pages = Context::$pageRepository->findChildPages($pageID);

        return ($structure) ? $this->getPageStructures($pages) : $pages;
    }

    private function getPageStructures($pages)
    {
        $pageStructures = [];
        if (is_array($pages) && sizeof($pages) > 0) {
            foreach ($pages as $page) {
                $pageStructures[] = PageStructure::toStructure($page);
            }
        }

        return $pageStructures;
    }
}
