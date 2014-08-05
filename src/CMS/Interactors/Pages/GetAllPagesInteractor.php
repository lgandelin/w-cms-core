<?php

namespace CMS\Interactors\Pages;

use CMS\Repositories\PageRepositoryInterface;
use CMS\UseCases\Pages\GetAllPagesUseCase;

class GetAllPagesInteractor implements GetAllPagesUseCase
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