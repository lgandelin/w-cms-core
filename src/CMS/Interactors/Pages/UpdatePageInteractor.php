<?php

namespace CMS\Interactors\Pages;

use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Areas\UpdateAreaInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Repositories\PageRepositoryInterface;
use CMS\Structures\AreaStructure;
use CMS\Structures\BlockStructure;

class UpdatePageInteractor extends GetPageInteractor
{
    public function __construct(PageRepositoryInterface $repository, GetAreasInteractor $getAreasInteractor, UpdateAreaInteractor $updateAreaInteractor, GetBlocksInteractor $getBlocksInteractor, UpdateBlockInteractor $updateBlockInteractor)
    {
        $this->repository = $repository;
        $this->getAreasInteractor = $getAreasInteractor;
        $this->updateAreaInteractor = $updateAreaInteractor;
        $this->getBlocksInteractor = $getBlocksInteractor;
        $this->updateBlockInteractor = $updateBlockInteractor;
    }

    public function run($pageID, $pageStructure)
    {
        $page = $this->getPageByID($pageID);

        if (isset($pageStructure->name) && $pageStructure->name !== null && $page->getName() != $pageStructure->name) {
            $page->setName($pageStructure->name);
        }

        if (isset($pageStructure->uri) && $pageStructure->uri !== null && $page->getURI() != $pageStructure->uri) {
            $page->setURI($pageStructure->uri);
        }

        if (isset($pageStructure->identifier) && $pageStructure->identifier !== null && $page->getIdentifier() != $pageStructure->identifier) {
            $page->setIdentifier($pageStructure->identifier);
        }

        if (isset($pageStructure->meta_title) && $pageStructure->meta_title !== null && $page->getMetaTitle() != $pageStructure->meta_title) {
            $page->setMetaTitle($pageStructure->meta_title);
        }

        if (isset($pageStructure->meta_description) && $pageStructure->meta_description !== null && $page->getMetaDescription() != $pageStructure->meta_description) {
            $page->setMetaDescription($pageStructure->meta_description);
        }

        if (isset($pageStructure->meta_keywords) && $pageStructure->meta_keywords !== null && $page->getMetaKeywords() != $pageStructure->meta_keywords) {
            $page->setMetaKeywords($pageStructure->meta_keywords);
        }

        if (isset($pageStructure->is_master) && $pageStructure->is_master !== null && $page->getIsMaster() != $pageStructure->is_master) {
            $page->setIsMaster($pageStructure->is_master);
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
