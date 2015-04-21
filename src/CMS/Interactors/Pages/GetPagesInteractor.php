<?php

namespace CMS\Interactors\Pages;

use CMS\Repositories\PageRepositoryInterface;
use CMS\Structures\PageStructure;

class GetPagesInteractor
{
    private $repository;

    public function __construct(PageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll($langID = null, $structure = false)
    {
        $pages = $this->repository->findAll($langID);

        return ($structure) ? $this->getPageStructures($pages) : $pages;
    }

    public function getMasterPages($structure = false)
    {
        $pages = $this->repository->findMasterPages();

        return ($structure) ? $this->getPageStructures($pages) : $pages;
    }

    public function getChildPages($pageID, $structure = false)
    {
        $pages = $this->repository->findChildPages($pageID);

        return ($structure) ? $this->getPageStructures($pages) : $pages;
    }

    private function getPageStructures($pages)
    {
        $pageStructures = [];
        if (is_array($pages) && sizeof($pages) > 0) {
            foreach ($pages as $page) {
                $pageStructures[] = PageStructure::toStructure($page);
            }
        }

        return $pageStructures;
    }
}
