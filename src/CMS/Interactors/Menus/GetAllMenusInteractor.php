<?php

namespace CMS\Interactors\Menus;

use CMS\Repositories\MenuRepositoryInterface;
use CMS\UseCases\Menus\GetAllMenusUseCase;

class GetAllMenusInteractor implements GetAllMenusUseCase
{

    protected $repository;

    public function __construct(MenuRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getAll()
    {
        return $this->repository->findAll();
    }
} 