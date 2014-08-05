<?php

namespace CMS\Interactors\Pages;

use CMS\Converters\PageConverter;
use CMS\UseCases\Pages\UpdatePageUseCase;

class UpdatePageInteractor extends GetPageInteractor implements UpdatePageUseCase
{

    public function run($pageID, $pageStructure)
    {
        if ($originalPageStructure = $this->getByID($pageID)) {
            $pageUpdated = $this->getPageUpdated($originalPageStructure, $pageStructure);

            if ($pageUpdated->valid()) {
                if ($this->anotherPageExistsWithSameURI($pageID, $pageUpdated->getURI()))
                    throw new \Exception('There is already a page with the same URI');

                if ($this->anotherPageExistsWithSameIdentifier($pageID, $pageUpdated->getIdentifier()))
                    throw new \Exception('There is already a page with the same identifier');

                $pageUpdatedStructure = PageConverter::convertPageToPageStructure($pageUpdated);
                $this->pageRepository->updatePage($pageID, $pageUpdatedStructure);
            }
        }
    }

    public function getPageUpdated($originalPageStructure, $pageStructure)
    {
        $page = PageConverter::convertPageStructureToPage($originalPageStructure);

        if (isset($pageStructure->name) && $pageStructure->name !== null && $page->getName() != $pageStructure->name) $page->setName($pageStructure->name);
        if (isset($pageStructure->uri) && $pageStructure->uri !== null && $page->getURI() != $pageStructure->uri) $page->setURI($pageStructure->uri);
        if (isset($pageStructure->identifier) && $pageStructure->identifier !== null && $page->getIdentifier() != $pageStructure->identifier) $page->setIdentifier($pageStructure->identifier);
        if (isset($pageStructure->text) && $pageStructure->text !== null && $page->getText() != $pageStructure->text) $page->setText($pageStructure->text);
        if (isset($pageStructure->meta_title) && $pageStructure->meta_title !== null && $page->getMetaTitle() != $pageStructure->meta_title) $page->setMetaTitle($pageStructure->meta_title);
        if (isset($pageStructure->meta_description) && $pageStructure->meta_description !== null && $page->getMetaDescription() != $pageStructure->meta_description) $page->setMetaDescription($pageStructure->meta_description);
        if (isset($pageStructure->meta_keywords) && $pageStructure->meta_keywords !== null && $page->getMetaKeywords() != $pageStructure->meta_keywords) $page->setMetaKeywords($pageStructure->meta_keywords);

        return $page;
    }

    public function anotherPageExistsWithSameURI($pageID, $pageURI)
    {
        $existingPageStructure = $this->pageRepository->findByUri($pageURI);

        return ($existingPageStructure && $existingPageStructure->ID != $pageID);
    }

    public function anotherPageExistsWithSameIdentifier($pageID, $pageIdentifier)
    {
        $existingPageStructure = $this->pageRepository->findByIdentifier($pageIdentifier);

        return ($existingPageStructure && $existingPageStructure->ID != $pageID);
    }
}