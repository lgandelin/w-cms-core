<?php

namespace CMS\Repositories\InMemory;

use CMS\Entities\Page;
use CMS\Repositories\PageRepositoryInterface;

class InMemoryPageRepository implements PageRepositoryInterface
{
    private $pages;

    public function __construct()
    {
        $this->pages = [];
    }

    public function findByID($pageID)
    {
        foreach ($this->pages as $page) {
            if ($page->getID() == $pageID) {
                return $page;
            }
        }

        return false;
    }

    public function findByUri($pageUri)
    {
        foreach ($this->pages as $page) {
            if ($page->getURI() == $pageUri) {
                return $page;
            }
        }

        return false;
    }

    public function findByIdentifier($pageIdentifier)
    {
        foreach ($this->pages as $page) {
            if ($page->getIdentifier() == $pageIdentifier) {
                return $page;
            }
        }

        return false;
    }

    public function findAll()
    {
        return $this->pages;
    }

    public function createPage(Page $page)
    {
        $pageID = sizeof($this->pages) + 1;
        $page->setID($pageID);
        $this->pages[]= $page;

        return $pageID;
    }

    public function updatePage(Page $page)
    {
        foreach ($this->pages as $pageModel) {
            if ($pageModel->getID() == $page->getID()) {
                $pageModel->setName($page->getName());
                $pageModel->setURI($page->getURI());
                $pageModel->setIdentifier($page->getIdentifier());
                $pageModel->setMetaTitle($page->getMetaTitle());
                $pageModel->setMetaDescription($page->getMetaDescription());
                $pageModel->setMetaKeywords($page->getMetaKeywords());
            }
        }
    }

    public function deletePage($pageID)
    {
        foreach ($this->pages as $i => $page) {
            if ($page->getID() == $pageID) {
                unset($this->pages[$i]);
            }
        }
    }
}
