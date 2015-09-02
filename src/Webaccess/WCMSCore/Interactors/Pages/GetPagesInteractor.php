<?php

namespace Webaccess\WCMSCore\Interactors\Pages;

use Webaccess\WCMSCore\Context;

class GetPagesInteractor
{
    public function getAll($langID = null, $structure = false)
    {
        $pages = Context::get('page')->findAll($langID);

        return ($structure) ? $this->getDataStructures($pages) : $pages;
    }

    public function getMasterPages($structure = false)
    {
        $pages = Context::get('page')->findMasterPages();

        return ($structure) ? $this->getDataStructures($pages) : $pages;
    }

    public function getChildPages($pageID, $structure = false)
    {
        $pages = Context::get('page')->findChildPages($pageID);

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
