<?php

namespace Webaccess\WCMSCore\Interactors\Versions;


use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Version;
use Webaccess\WCMSCore\Interactors\Areas\DuplicateAreaInteractor;
use Webaccess\WCMSCore\Interactors\Areas\GetAreasInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\DuplicateBlockInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlocksInteractor;

class CreatePageVersionInteractor
{
    public function run($page, $areaID = null, $blockID = null)
    {
        $version = false;
        $newAreaIDReference = null;
        $newBlockIDReference = null;
        $currentVersion = Context::get('version_repository')->findByID($page->getVersionID());
        if ($currentVersion) {
            $version = new Version();
            $version->setPageID($page->getID());
            $version->setNumber($currentVersion->getNumber() + 1);
            $versionID = Context::get('version_repository')->createVersion($version);

            $page->setDraftVersionID($versionID);
            Context::get('page_repository')->updatePage($page);
        }

        if ($currentVersion && $version) {
            foreach ((new GetAreasInteractor())->getByPageIDAndVersionNumber($page->getID(), $currentVersion->getNumber()) as $area) {
                $newAreaStructure = $area->toStructure();
                $newAreaStructure->versionNumber = $version->getNumber();
                list($newAreaID, $newPageVersion) = (new DuplicateAreaInteractor())->run($newAreaStructure, $page->getID());

                if ($areaID == $area->getID()) {
                    $newAreaIDReference = $newAreaID;
                }

                foreach ((new GetBlocksInteractor())->getAllByAreaID($area->getID()) as $block) {
                    $newBlockID = (new DuplicateBlockInteractor())->run($block, $newAreaID, $version->getNumber());

                    if ($blockID == $block->getID()) {
                        $newBlockIDReference = $newBlockID;
                        $newAreaIDReference = $newAreaID;
                    }
                }
            }
        }

        return array($newAreaIDReference, $newBlockIDReference, ($version ? $version->getNumber() : null));
    }
}
