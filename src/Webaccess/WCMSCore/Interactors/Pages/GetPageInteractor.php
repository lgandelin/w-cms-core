<?php

namespace Webaccess\WCMSCore\Interactors\Pages;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Areas\GetAreaInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlockInteractor;

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

    public function getPageFromAreaID($areaID)
    {
        if ($area = (new GetAreaInteractor())->getAreaByID($areaID)) {
            if ($area->getPageID() != null && $page = (new GetPageInteractor())->getPageByID($area->getPageID())) {
                return $page;
            }
        }

        return false;
    }

    public function getPageFromBlockID($blockID)
    {
        if ($block = (new GetBlockInteractor())->getBlockByID($blockID)) {
            if ($block->getAreaID() != null && $area = (new GetAreaInteractor())->getAreaByID($block->getAreaID())) {
                if ($area->getPageID() != null && $page = (new GetPageInteractor())->getPageByID($area->getPageID())) {
                    return $page;
                }
            }
        }

        return false;
    }
}
