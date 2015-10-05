<?php

namespace Webaccess\WCMSCore\Interactors\Versions;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Pages\GetPageInteractor;

class UpdatePageVersionInteractor
{
    public function runAfterAreaModification($areaID)
    {
        if ($page = (new GetPageInteractor())->getPageFromAreaID($areaID)) {
            $this->updatePageVersionIfNeeded($page);
        }
    }

    public function runAfterBlockModification($blockID)
    {
        if ($page = (new GetPageInteractor())->getPageFromBlockID($blockID)) {
            $this->updatePageVersionIfNeeded($page);
        }
    }

    private function updatePageVersionIfNeeded($page)
    {
        if ($page->isNewVersionNeeded()) {
            $page->setDraftVersionNumber($page->getDraftVersionNumber() + 1);
            Context::get('page_repository')->updatePage($page);
        }
    }
}
