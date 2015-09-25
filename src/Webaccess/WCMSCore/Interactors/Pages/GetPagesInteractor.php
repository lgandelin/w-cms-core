<?php

namespace Webaccess\WCMSCore\Interactors\Pages;

use Webaccess\WCMSCore\Context;

class GetPagesInteractor
{
    public function getAll($langID = null, $structure = false)
    {
        $pages = Context::get('page_repository')->findAll($langID);

        return ($structure) ? $this->getDataStructures($pages) : $pages;
    }

    public function getMasterPages($structure = false)
    {
        $pages = Context::get('page_repository')->findMasterPages();

        return ($structure) ? $this->getDataStructures($pages) : $pages;
    }

    public function getChildPages($pageID, $structure = false)
    {
        $pages = Context::get('page_repository')->findChildPages($pageID);

        return ($structure) ? $this->getDataStructures($pages) : $pages;
    }

    private function getDataStructures($pages)
    {
        return array_map(function($page) {
            return $page->toStructure();
        }, $pages);
    }
}
