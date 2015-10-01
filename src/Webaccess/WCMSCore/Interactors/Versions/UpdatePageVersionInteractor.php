<?php

namespace Webaccess\WCMSCore\Interactors\Versions;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Areas\GetAreaInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlockInteractor;
use Webaccess\WCMSCore\Interactors\Pages\GetPageInteractor;

class UpdatePageVersionInteractor
{
    public function runAfterAreaModification($areaID)
    {
        if ($page = $this->getPageFromAreaID($areaID)) {
            $this->updatePageVersionIfNeeded($page);
        }
    }

    public function runAfterBlockModification($blockID)
    {
        if ($page = $this->getPageFromBlockID($blockID)) {
            $this->updatePageVersionIfNeeded($page);
        }
    }

    private function getPageFromAreaID($areaID)
    {
        if ($area = (new GetAreaInteractor())->getAreaByID($areaID)) {
            if ($area->getPageID() != null && $page = (new GetPageInteractor())->getPageByID($area->getPageID())) {
                return $page;
            }
        }
    }

    private function getPageFromBlockID($blockID)
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

    private function updatePageVersionIfNeeded($page)
    {
        if ($page->getVersionNumber() == $page->getDraftVersionNumber()) {
            $page->setDraftVersionNumber($page->getDraftVersionNumber() + 1);
            Context::get('page_repository')->updatePage($page);
        }
    }
}
