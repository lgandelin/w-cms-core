<?php

namespace Webaccess\WCMSCoreTests\Repositories;

use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Repositories\PageRepositoryInterface;

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

    public function findByUriAndLangID($pageUri, $langID)
    {
        foreach ($this->pages as $page) {
            if ($page->getURI() == $pageUri && $page->getLangID() == $langID) {
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

    public function findAll($lang = null)
    {
        return $this->pages;
    }

    public function findChildPages($pageID)
    {
        $pages = [];
        foreach ($this->pages as $page) {
            if ($page->getMasterPageID() == $pageID) {
                $pages[]= $page;
            }
        }

        return $pages;
    }

    public function findMasterPages()
    {
        return [];
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
                //$pageModel->setVersionNumber($page->getVersionNumber());
                //$pageModel->setDraftVersionNumber($page->getDraftVersionNumber());
                $pageModel->setVersionID($page->getVersionID());
                $pageModel->setDraftVersionID($page->getDraftVersionID());
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
