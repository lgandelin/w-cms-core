<?php

namespace CMS\Interactors\Pages;

class UpdatePageInteractor extends GetPageInteractor
{
    public function run($pageID, $pageStructure)
    {
        $page = $this->getPageByID($pageID);

        if (isset($pageStructure->name) && $pageStructure->name !== null && $page->getName() != $pageStructure->name) $page->setName($pageStructure->name);
        if (isset($pageStructure->uri) && $pageStructure->uri !== null && $page->getURI() != $pageStructure->uri) $page->setURI($pageStructure->uri);
        if (isset($pageStructure->identifier) && $pageStructure->identifier !== null && $page->getIdentifier() != $pageStructure->identifier) $page->setIdentifier($pageStructure->identifier);
        if (isset($pageStructure->meta_title) && $pageStructure->meta_title !== null && $page->getMetaTitle() != $pageStructure->meta_title) $page->setMetaTitle($pageStructure->meta_title);
        if (isset($pageStructure->meta_description) && $pageStructure->meta_description !== null && $page->getMetaDescription() != $pageStructure->meta_description) $page->setMetaDescription($pageStructure->meta_description);
        if (isset($pageStructure->meta_keywords) && $pageStructure->meta_keywords !== null && $page->getMetaKeywords() != $pageStructure->meta_keywords) $page->setMetaKeywords($pageStructure->meta_keywords);

        $page->valid();

        if ($this->anotherPageExistsWithSameURI($pageID, $page->getURI()))
            throw new \Exception('There is already a page with the same URI');

        if ($this->anotherPageExistsWithSameIdentifier($pageID, $page->getIdentifier()))
            throw new \Exception('There is already a page with the same identifier');

        $this->repository->updatePage($page);
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