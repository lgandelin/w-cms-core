<?php

namespace CMS\Interactors\Menus;

use CMS\Repositories\MenuRepositoryInterface;

class GetMenusInteractor
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