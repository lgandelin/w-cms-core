<?php

namespace CMS\Services;

class PageManager {

    public function __construct($pageRepository = null)
    {
        $this->pageRepository = $pageRepository;
    }

    public function getByIdentifier($identifier)
    {
        $page = $this->pageRepository->findByIdentifier($identifier);

        if (!$page)
            throw new \Exception('The page was not found');

        return  new \CMS\Structures\PageStructure([
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

        return  new \CMS\Structures\PageStructure([
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
        return $this->pageRepository->findAll();
    }

    public function createPage(\CMS\Structures\PageStructure $pageStructure)
    {
        if (!$pageStructure->identifier)
            throw new \InvalidArgumentException('You must provide an identifier for a page');

        if (!$pageStructure->uri)
            throw new \InvalidArgumentException('You must provide a URI for a page');

        if ($this->pageRepository->findByIdentifier($pageStructure->identifier))
            throw new \Exception('There is already a page with the same identifier');

        if ($this->pageRepository->findByUri($pageStructure->uri))
            throw new \Exception('There is already a page with the same URI');

        $page = new \CMS\Entities\Page();
        $page->setName($pageStructure->name);
        $page->setUri($pageStructure->uri);
        $page->setIdentifier($pageStructure->identifier);
        $page->setText($pageStructure->text);
        $page->setMetaTitle($pageStructure->meta_title);
        $page->setMetaDescription($pageStructure->meta_description);
        $page->setMetaKeywords($pageStructure->meta_keywords);

        return $this->pageRepository->createPage($page);
    }

    public function updatePage(\CMS\Structures\PageStructure $pageStructure)
    {
        if (!$page = $this->pageRepository->findByIdentifier($pageStructure->identifier))
            throw new \Exception('The page was not found');

        $existingPage = $this->pageRepository->findByUri($page->getUri());

        if ($existingPage != null && $existingPage->getUri() != $pageStructure->uri)
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