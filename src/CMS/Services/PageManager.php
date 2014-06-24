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
        $page = $this->pageRepository->findByIdentifier($identifier);

        if (!$page)
            throw new \Exception('The page was not found');

        return new PageStructure([
            'name' => $page->getName(),
            'uri' => $page->getUri(),
            'identifier' => $page->getIdentifier(),
            'text' => $page->getText(),
            'meta_title' => $page->getMetaTitle(),
            'meta_description' => $page->getMetaDescription(),
            'meta_keywords' => $page->getMetaKeywords()
       ]);
    }

    public function getByUri($uri)
    {
        $page = $this->pageRepository->findByUri($uri);

        if (!$page)
            throw new \Exception('The page was not found');

        return new PageStructure([
            'name' => $page->getName(),
            'uri' => $page->getUri(),
            'identifier' => $page->getIdentifier(),
            'text' => $page->getText(),
            'meta_title' => $page->getMetaTitle(),
            'meta_description' => $page->getMetaDescription(),
            'meta_keywords' => $page->getMetaKeywords()
        ]);
    }

    public function getAll()
    {
        $pages = $this->pageRepository->findAll();

        $pagesS = [];
        if (is_array($pages) && sizeof($pages) > 0) {
            foreach ($pages as $i => $page) {
                $pagesS[]= new PageStructure([
                    'name' => $page->getName(),
                    'uri' => $page->getUri(),
                    'identifier' => $page->getIdentifier(),
                    'text' => $page->getText(),
                    'meta_title' => $page->getMetaTitle(),
                    'meta_description' => $page->getMetaDescription(),
                    'meta_keywords' => $page->getMetaKeywords()
                ]);
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

        $page = new Page();
        $page->setName($pageStructure->name);
        $page->setUri($pageStructure->uri);
        $page->setIdentifier($pageStructure->identifier);
        $page->setText($pageStructure->text);
        $page->setMetaTitle($pageStructure->meta_title);
        $page->setMetaDescription($pageStructure->meta_description);
        $page->setMetaKeywords($pageStructure->meta_keywords);

        return $this->pageRepository->createPage($page);
    }

    public function updatePage(PageStructure $pageStructure)
    {
        if (!$page = $this->pageRepository->findByIdentifier($pageStructure->identifier))
            throw new \Exception('The page was not found');

        $existingPage = $this->pageRepository->findByUri($pageStructure->uri);

        if ($existingPage != null && $existingPage->getIdentifier() != $pageStructure->identifier)
            throw new \Exception('There is already a page with the same URI');

        $page->setName($pageStructure->name);
        $page->setUri($pageStructure->uri);
        $page->setText($pageStructure->text);
        $page->setMetaTitle($pageStructure->meta_title);
        $page->setMetaDescription($pageStructure->meta_description);
        $page->setMetaKeywords($pageStructure->meta_keywords);

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