<?php

namespace CMS\Interactors\Pages;

use CMS\Repositories\PageRepositoryInterface;
use CMS\UseCases\Pages\GetPageUseCase;

class GetPageInteractor implements GetPageUseCase
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

}