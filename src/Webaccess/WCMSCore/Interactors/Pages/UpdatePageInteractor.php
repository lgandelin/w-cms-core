<?php

namespace Webaccess\WCMSCore\Interactors\Pages;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Areas\GetAreasInteractor;
use Webaccess\WCMSCore\Interactors\Areas\UpdateAreaInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlocksInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\UpdateBlockInteractor;
use Webaccess\WCMSCore\DataStructure;

class UpdatePageInteractor extends GetPageInteractor
{
    public function run($pageID, DataStructure $pageStructure)
    {
        $page = $this->getPageByID($pageID);
        $page->setInfos($pageStructure);
        $page->valid();

        if ($this->anotherPageExistsWithSameURI($pageID, $page->getURI())) {
            throw new \Exception('There is already a page with the same URI');
        }

        if ($this->anotherPageExistsWithSameIdentifier($pageID, $page->getIdentifier())) {
            throw new \Exception('There is already a page with the same identifier');
        }

        Context::get('page_repository')->updatePage($page);
        $this->updateIsMasterFields($page);
    }

    private function anotherPageExistsWithSameURI($pageID, $pageURI)
    {
        $existingDataStructure = Context::get('page_repository')->findByUri($pageURI);

        return ($existingDataStructure && $existingDataStructure->getID() != $pageID);
    }

    private function anotherPageExistsWithSameIdentifier($pageID, $pageIdentifier)
    {
        $existingDataStructure = Context::get('page_repository')->findByIdentifier($pageIdentifier);

        return ($existingDataStructure && $existingDataStructure->getID() != $pageID);
    }

    private function updateIsMasterFields($page)
    {
        $areas = (new GetAreasInteractor())->getAll($page->getID());

        if (is_array($areas) && sizeof($areas) > 0) {
            foreach ($areas as $area) {

                $areaStructure = new DataStructure([
                    'is_master' => $page->getIsMaster()
                ]);
                (new UpdateAreaInteractor())->run($area->getID(), $areaStructure);

                $blocks = (new GetBlocksInteractor())->getAllByAreaID($area->getID());

                if (is_array($blocks) && sizeof($blocks) > 0) {
                    foreach ($blocks as $block) {
                        $blockStructure = $block->toStructure();
                        $blockStructure->is_master = $page->getIsMaster();
                        (new UpdateBlockInteractor())->run($block->getID(), $blockStructure);
                    }
                }
            }
        }
    }
}
