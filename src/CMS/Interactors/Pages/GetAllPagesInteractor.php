<?php

namespace CMS\Interactors\Pages;

use CMS\Repositories\PageRepositoryInterface;

class GetAllPagesInteractor
{
    private $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function getAll()
    {
        return $this->pageRepository->findAll();
    }

}