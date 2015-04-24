<?php

namespace CMS\Interactors\Pages;

use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Areas\UpdateAreaInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Repositories\PageRepositoryInterface;
use CMS\Structures\AreaStructure;
use CMS\Structures\PageStructure;

class UpdatePageInteractor extends GetPageInteractor
{
    public function __construct(
        PageRepositoryInterface $repository,
        GetAreasInteractor $getAreasInteractor,
        UpdateAreaInteractor $updateAreaInteractor,
        GetBlocksInteractor $getBlocksInteractor,
        UpdateBlockInteractor $updateBlockInteractor
    ) {
        $this->repository = $repository;
        $this->getAreasInteractor = $getAreasInteractor;
        $this->updateAreaInteractor = $updateAreaInteractor;
        $this->getBlocksInteractor = $getBlocksInteractor;
        $this->updateBlockInteractor = $updateBlockInteractor;
    }

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

        $this->repository->updatePage($page);

        //Update is_master fields
        $areas = $this->getAreasInteractor->getAll($page->getID());

        if (is_array($areas) && sizeof($areas) > 0) {
            foreach ($areas as $area) {

                $areaStructure = new AreaStructure([
                    'is_master' => $page->getIsMaster()
                ]);
                $this->updateAreaInteractor->run($area->getID(), $areaStructure);

                $blocks = $this->getBlocksInteractor->getAllByAreaID($area->getID());

                if (is_array($blocks) && sizeof($blocks) > 0) {
                    foreach ($blocks as $block) {
                        $blockStructure = $block->getStructure();
                        $blockStructure->is_master = $page->getIsMaster();
                        $this->updateBlockInteractor->run($block->getID(), $blockStructure);
                    }
                }
            }
        }
    }

    private function anotherPageExistsWithSameURI($pageID, $pageURI)
    {
        $existingPageStructure = $this->repository->findByUri($pageURI);

        return ($existingPageStructure && $existingPageStructure->getID() != $pageID);
    }

    private function anotherPageExistsWithSameIdentifier($pageID, $pageIdentifier)
    {
        $existingPageStructure = $this->repository->findByIdentifier($pageIdentifier);

        return ($existingPageStructure && $existingPageStructure->getID() != $pageID);
    }
}
