<?php

namespace CMS\Interactors\Menus;

use CMS\Repositories\MenuRepositoryInterface;
use CMS\Structures\MenuStructure;

class GetMenuInteractor
{
    protected $repository;

    public function __construct(MenuRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getMenuByID($menuID, $structure = false)
    {
        if (!$menu = $this->repository->findByID($menuID))
            throw new \Exception('The menu was not found');

        return ($structure) ? MenuStructure::toStructure($menu) : $menu;
    }

    private function getMenuByIdentifier($menuIdentifier, $structure = false)
    {
        if (!$menu = $this->repository->findByIdentifier($menuIdentifier))
            throw new \Exception('The menu was not found');

        return ($structure) ? MenuStructure::toStructure($menu) : $menu;
    }
}