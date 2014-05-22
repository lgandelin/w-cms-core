<?php

namespace CMS\Services;

class PageManager {

    public function __construct($pageMapper = null)
    {
        $this->pageMapper = $pageMapper;
    }

    public function getByIdentifier($identifier)
    {
        return $this->pageMapper->findByIdentifier($identifier);
    }

    public function getByUri($uri)
    {
        return $this->pageMapper->findByUri($uri);
    }

    public function getAll()
    {
        return $this->pageMapper->findAll();
    }

    static public function createPageObject($name, $uri, $identifier = '', $text = '')
    {
        if (!$name) throw new \InvalidArgumentException('You must provide a name for a page');
        if (!$uri) throw new \InvalidArgumentException('You must provide a Uri for a page');
        if (!$identifier) $identifier = str_replace('/', '-', ltrim($uri, '/'));

        $page = new \CMS\Entities\Page();
        $page->setName($name);
        $page->setIdentifier($identifier);
        $page->setUri($uri);
        $page->setText($text);

        return $page;
    }

    static public function duplicatePageObject(\CMS\Entities\Page $page)
    {
        return self::createPageObject($page->getName() . ' COPY', $page->getUri() . '-copy', $page->getIdentifier() . '-copy', $page->getText());
    }

    public function createPage(\CMS\Entities\Page $page)
    {
        if ($this->pageMapper->findByUri($page->getUri()))
            throw new \Exception('There is already a page with the same uri');

        if ($this->pageMapper->findByIdentifier($page->getIdentifier()))
            throw new \Exception('There is already a page with the same identifier');

        return $this->pageMapper->createPage($page);
    }

    public function updatePage(\CMS\Entities\Page $page)
    {
        $existingPage = $this->pageMapper->findByUri($page->getUri());
        if ($existingPage != null && $existingPage->getIdentifier() != $page->getIdentifier())
            throw new \Exception('There is already a page with the same uri');

        if (!$this->pageMapper->findByIdentifier($page->getIdentifier()))
            throw new \Exception('The page was not found');

        return $this->pageMapper->updatePage($page);
    }

    public function deletePage(\CMS\Entities\Page $page)
    {
        if (!$this->pageMapper->findByIdentifier($page->getIdentifier()))
            throw new \Exception('The page was not found');

        return $this->pageMapper->deletePage($page);
    }
}