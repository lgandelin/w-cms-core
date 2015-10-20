<?php

namespace Webaccess\WCMSCore\Interactors\Versions;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Version;
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
            $currentVersion = Context::get('version_repository')->findByID($page->getID());
            if ($currentVersion) {
                $version = new Version();
                $version->setPageID($page->getID());
                $version->setNumber($currentVersion->getNumber() + 1);
                $versionID = Context::get('version_repository')->createVersion($version);

                $page->setDraftVersionID($versionID);
                Context::get('page_repository')->updatePage($page);
            }
        }
    }
}
