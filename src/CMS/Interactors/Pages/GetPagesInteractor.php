<?php

namespace CMS\Interactors\Pages;

use CMS\Context;
use CMS\Structures\DataStructure;

class GetPagesInteractor
{
    public function getAll($langID = null, $structure = false)
    {
        $pages = Context::getRepository('page')->findAll($langID);

        return ($structure) ? $this->getDataStructures($pages) : $pages;
    }

    public function getMasterPages($structure = false)
    {
        $pages = Context::getRepository('page')->findMasterPages();

        return ($structure) ? $this->getDataStructures($pages) : $pages;
    }

    public function getChildPages($pageID, $structure = false)
    {
        $pages = Context::getRepository('page')->findChildPages($pageID);

        return ($structure) ? $this->getDataStructures($pages) : $pages;
    }

    private function getDataStructures($pages)
    {
        $pageStructures = [];
        if (is_array($pages) && sizeof($pages) > 0) {
            foreach ($pages as $page) {
                $pageStructures[] = $page->toStructure();
            }
        }

        return $pageStructures;
    }
}
