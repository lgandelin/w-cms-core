<?php

namespace CMS\Interactors\Pages;

use CMS\Context;
use CMS\Entities\Page;
use CMS\Structures\PageStructure;

class CreatePageInteractor
{
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

        return Context::$pageRepository->createPage($page);
    }

    private function anotherExistingPageWithSameIdentifier($identifier)
    {
        return Context::$pageRepository->findByIdentifier($identifier);
    }

    private function anotherExistingPageWithSameUri($uri)
    {
        return Context::$pageRepository->findByUri($uri);
    }

    private function createPageFromStructure(PageStructure $pageStructure)
    {
        $page = new Page();
        $page->setID($pageStructure->ID);
        $page->setIdentifier($pageStructure->identifier);
        $page->setName($pageStructure->name);
        $page->setUri($pageStructure->uri);
        $page->setLangID($pageStructure->lang_id);
        $page->setMetaTitle($pageStructure->meta_title);
        $page->setMetaDescription($pageStructure->meta_description);
        $page->setMetaKeywords($pageStructure->meta_keywords);
        $page->setIsMaster($pageStructure->is_master);
        $page->setMasterPageID($pageStructure->master_page_id);

        return $page;
    }
}
