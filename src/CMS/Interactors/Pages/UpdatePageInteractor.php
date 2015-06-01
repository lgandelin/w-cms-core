<?php

namespace CMS\Interactors\Pages;

use CMS\Context;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Areas\UpdateAreaInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Repositories\PageRepositoryInterface;
use CMS\Structures\AreaStructure;
use CMS\Structures\PageStructure;

class UpdatePageInteractor extends GetPageInteractor
{
    public function run($pageID, PageStructure $pageStructure)
    {
        $page = $this->getPageByID($pageID);

        $properties = get_object_vars($pageStructure);
        unset ($properties['ID']);
        unset ($properties['master_page_id']);
        foreach ($properties as $property => $value) {
            $method = ucfirst(str_replace('_', '', $property));
            $setter = 'set' . $method;

            if ($pageStructure->$property !== null) {
                call_user_func_array(array($page, $setter), array($value));
            }
        }

        $page->valid();

        if ($this->anotherPageExistsWithSameURI($pageID, $page->getURI())) {
            throw new \Exception('There is already a page with the same URI');
        }

        if ($this->anotherPageExistsWithSameIdentifier($pageID, $page->getIdentifier())) {
            throw new \Exception('There is already a page with the same identifier');
        }

        Context::$pageRepository->updatePage($page);

        //Update is_master fields
        $areas = (new getAreasInteractor())->getAll($page->getID());

        if (is_array($areas) && sizeof($areas) > 0) {
            foreach ($areas as $area) {

                $areaStructure = new AreaStructure([
                    'is_master' => $page->getIsMaster()
                ]);
                (new UpdateAreaInteractor())->run($area->getID(), $areaStructure);

                $blocks = (new GetBlocksInteractor())->getAllByAreaID($area->getID());

                if (is_array($blocks) && sizeof($blocks) > 0) {
                    foreach ($blocks as $block) {
                        $blockStructure = $block->getStructure();
                        $blockStructure->is_master = $page->getIsMaster();
                        (new UpdateBlockInteractor())->run($block->getID(), $blockStructure);
                    }
                }
            }
        }
    }

    private function anotherPageExistsWithSameURI($pageID, $pageURI)
    {
        $existingPageStructure = Context::$pageRepository->findByUri($pageURI);

        return ($existingPageStructure && $existingPageStructure->getID() != $pageID);
    }

    private function anotherPageExistsWithSameIdentifier($pageID, $pageIdentifier)
    {
        $existingPageStructure = Context::$pageRepository->findByIdentifier($pageIdentifier);

        return ($existingPageStructure && $existingPageStructure->getID() != $pageID);
    }
}
