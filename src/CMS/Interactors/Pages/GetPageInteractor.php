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

    public function getPageByURI($pageURI, $langID, $structure = false)
    {
        if (!$page = $this->repository->findByUriAndLangID($pageURI, $langID)) {
            throw new \Exception('The page was not found');
        }

        return ($structure) ? PageStructure::toStructure($page) : $page;
    }
}
