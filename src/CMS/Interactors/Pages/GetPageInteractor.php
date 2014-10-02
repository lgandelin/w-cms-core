<?php

namespace CMS\Interactors\Pages;

use CMS\Repositories\PageRepositoryInterface;

class GetPageInteractor
{
    protected $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function getByID($pageID)
    {
        $pageStructure = $this->pageRepository->findByID($pageID);

        if (!$pageStructure)
            throw new \Exception('The page was not found');

        return $pageStructure;
    }

    public function getByURI($pageURI)
    {
        $pageStructure = $this->pageRepository->findByUri($pageURI);

        if (!$pageStructure)
            throw new \Exception('The page was not found');

        return $pageStructure;
    }

}