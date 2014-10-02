<?php

namespace CMS\Interactors\Pages;

use CMS\Converters\PageConverter;
use CMS\Repositories\PageRepositoryInterface;
use CMS\Structures\PageStructure;
use CMS\UseCases\Pages\CreatePageUseCase;

class CreatePageInteractor implements CreatePageUseCase
{
    protected $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function run(PageStructure $pageStructure)
    {
        $page = PageConverter::convertPageStructureToPage($pageStructure);

        if ($page->valid()) {
            if ($this->anotherExistingPageWithSameUri($page->getUri()))
                throw new \Exception('There is already a page with the same URI');

            if ($this->anotherExistingPageWithSameIdentifier($page->getIdentifier()))
                throw new \Exception('There is already a page with the same identifier');

            return $this->pageRepository->createPage(PageConverter::convertPageToPageStructure($page));
        }
    }

    public function anotherExistingPageWithSameIdentifier($identifier)
    {
        return $this->pageRepository->findByIdentifier($identifier);
    }

    public function anotherExistingPageWithSameUri($uri)
    {
        return $this->pageRepository->findByUri($uri);
    }

}