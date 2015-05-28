<?php

namespace CMS\Interactors\Pages;

use CMS\Repositories\PageRepositoryInterface;
use CMS\Structures\PageStructure;

class GetPageInteractor
{
    protected $repository;

    public function __construct(PageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getPageByID($pageID, $structure = false)
    {
        if (!$page = $this->repository->findByID($pageID)) {
            throw new \Exception('The page was not found');
        }

        return ($structure) ? PageStructure::toStructure($page) : $page;
    }

    public function getPageByURI($pageURI, $langID = null, $structure = false)
    {
        if ($langID) {
            $page = $this->repository->findByUriAndLangID($pageURI, $langID);
        } else {
            $page = $this->repository->findByUri($pageURI);
        }

        if (!$page) {
            throw new \Exception('The page was not found');
        }

        return ($structure) ? PageStructure::toStructure($page) : $page;
    }
}
