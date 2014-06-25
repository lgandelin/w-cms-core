<?php

namespace CMS\Services;

use CMS\Entities\Page;
use CMS\Structures\PageStructure;
use CMS\Repositories\PageRepositoryInterface;

class PageManager {

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function getByIdentifier($identifier)
    {
        if (!$page = $this->pageRepository->findByIdentifier($identifier))
            throw new \Exception('The page was not found');

        return PageStructure::convertPageToPageStructure($page);
    }

    public function getByUri($uri)
    {
        if (!$page = $this->pageRepository->findByUri($uri))
            throw new \Exception('The page was not found');

        return PageStructure::convertPageToPageStructure($page);
    }

    public function getAll()
    {
        $pages = $this->pageRepository->findAll();

        $pagesS = [];
        if (is_array($pages) && sizeof($pages) > 0) {
            foreach ($pages as $i => $page) {
                $pagesS[]= PageStructure::convertPageToPageStructure($page);
            }

            return $pagesS;
        }

        return false;
    }

    public function createPage(PageStructure $pageStructure)
    {
        if (!$pageStructure->identifier)
            throw new \InvalidArgumentException('You must provide an identifier for a page');

        if (!$pageStructure->uri)
            throw new \InvalidArgumentException('You must provide a URI for a page');

        if ($this->pageRepository->findByIdentifier($pageStructure->identifier))
            throw new \Exception('There is already a page with the same identifier');

        if ($this->pageRepository->findByUri($pageStructure->uri))
            throw new \Exception('There is already a page with the same URI');

        $page = PageStructure::convertPageStructureToPage($pageStructure);

        return $this->pageRepository->createPage($page);
    }

    public function updatePage(PageStructure $pageStructure)
    {
        if (!$page = $this->pageRepository->findByIdentifier($pageStructure->identifier))
            throw new \Exception('The page was not found');

        $existingPage = $this->pageRepository->findByUri($pageStructure->uri);

        if ($existingPage != null && $existingPage->getIdentifier() != $pageStructure->identifier)
            throw new \Exception('There is already a page with the same URI');

        $page = PageStructure::convertPageStructureToPage($pageStructure);

        return $this->pageRepository->updatePage($page);
    }

    public function deletePage($identifier)
    {
        if (!$page = $this->pageRepository->findByIdentifier($identifier))
            throw new \Exception('The page was not found');

        return $this->pageRepository->deletePage($page);
    }

    public function duplicatePage($identifier)
    {
        if (!$page = $this->pageRepository->findByIdentifier($identifier))
            throw new \Exception('The page was not found');

        $pageS = $this->getByIdentifier($identifier);
        $pageS->name .= ' COPY';
        $pageS->uri .= '-copy';
        $pageS->identifier .= '-copy';

        return $this->createPage($pageS);
    }
}