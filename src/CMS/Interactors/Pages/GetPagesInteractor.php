<?php

namespace CMS\Interactors\Pages;

use CMS\Context;
use CMS\Structures\PageStructure;

class GetPagesInteractor
{
    public function getAll($langID = null, $structure = false)
    {
        $pages = Context::getRepository('page')->findAll($langID);

        return ($structure) ? $this->getPageStructures($pages) : $pages;
    }

    public function getMasterPages($structure = false)
    {
        $pages = Context::getRepository('page')->findMasterPages();

        return ($structure) ? $this->getPageStructures($pages) : $pages;
    }

    public function getChildPages($pageID, $structure = false)
    {
        $pages = Context::getRepository('page')->findChildPages($pageID);

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
