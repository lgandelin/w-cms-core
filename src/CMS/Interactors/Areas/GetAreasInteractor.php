<?php

namespace CMS\Interactors\Areas;

use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Repositories\AreaRepositoryInterface;
use CMS\Repositories\PageRepositoryInterface;

class GetAreasInteractor extends GetPageInteractor {

    public function __construct(AreaRepositoryInterface $repository, PageRepositoryInterface $pageRepository)
    {
        $this->repository = $repository;
        $this->pageRepository = $pageRepository;
    }

    public function getAll($pageID)
    {
        if ($this->getPageByID($pageID))
            return $this->repository->findByPageID($pageID);
    }
}