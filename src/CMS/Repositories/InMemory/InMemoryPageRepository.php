<?php

namespace CMS\Repositories\InMemory;

use CMS\Repositories\PageRepositoryInterface;
use CMS\Structures\PageStructure;

class InMemoryPageRepository implements PageRepositoryInterface {

    private $pages;

    public function __construct()
    {
        $this->pages = [];
    }

    public function findByID($pageID)
    {
        foreach ($this->pages as $page) {
            if ($page->ID == $pageID)
                return $page;
        }

        return false;
    }

    public function findByUri($pageUri)
    {
        foreach ($this->pages as $page) {
            if ($page->uri == $pageUri)
                return $page;
        }

        return false;
    }

    public function findByIdentifier($pageIdentifier)
    {
        foreach ($this->pages as $page) {
            if ($page->identifier == $pageIdentifier)
                return $page;
        }

        return false;
    }

    public function findAll()
    {
        return $this->pages;
    }

    public function createPage(PageStructure $pageStructure)
    {
        $this->pages[]= $pageStructure;
    }

    public function updatePage($pageID, PageStructure $pageStructure)
    {
        foreach ($this->pages as $i => $page) {
            if ($page->ID == $pageID) {
                $page->name = $pageStructure->name;
                $page->uri = $pageStructure->uri;
                $page->identifier = $pageStructure->identifier;
                $page->text = $pageStructure->text;
                $page->website = $pageStructure->website;
                $page->meta_title = $pageStructure->meta_title;
                $page->meta_description = $pageStructure->meta_description;
                $page->meta_keywords = $pageStructure->meta_keywords;
            }
        }
    }

    public function deletePage($pageID)
    {
        foreach ($this->pages as $i => $page) {
            if ($page->ID == $pageID) {
                unset($this->pages[$i]);
            }
        }
    }
}