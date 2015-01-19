<?php

namespace CMS\Interactors\Pages;

use CMS\Entities\Page;
use CMS\Interactors\Areas\DuplicateAreaInteractor;
use CMS\Interactors\Blocks\DuplicateBlockInteractor;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Repositories\PageRepositoryInterface;
use CMS\Structures\PageStructure;

class CreatePageInteractor
{
    protected $repository;

    public function __construct(PageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(PageStructure $pageStructure)
    {
        $page = $this->createPageFromStructure($pageStructure);

        $page->valid();

        if ($this->anotherExistingPageWithSameUri($page->getUri())) {
            throw new \Exception('There is already a page with the same URI');
        }

        if ($this->anotherExistingPageWithSameIdentifier($page->getIdentifier())) {
            throw new \Exception('There is already a page with the same identifier');
        }

        return $this->repository->createPage($page);
    }

    private function anotherExistingPageWithSameIdentifier($identifier)
    {
        return $this->repository->findByIdentifier($identifier);
    }

    private function anotherExistingPageWithSameUri($uri)
    {
        return $this->repository->findByUri($uri);
    }

    private function createPageFromStructure(PageStructure $pageStructure)
    {
        $page = new Page();
        $page->setID($pageStructure->ID);
        $page->setIdentifier($pageStructure->identifier);
        $page->setName($pageStructure->name);
        $page->setUri($pageStructure->uri);
        $page->setMetaTitle($pageStructure->meta_title);
        $page->setMetaDescription($pageStructure->meta_description);
        $page->setMetaKeywords($pageStructure->meta_keywords);
        $page->setIsMaster($pageStructure->is_master);
        $page->setMasterPageID($pageStructure->master_page_id);

        return $page;
    }
}
