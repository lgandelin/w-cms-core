<?php

namespace CMS\Interactors\Menus;

use CMS\Repositories\MenuRepositoryInterface;
use CMS\UseCases\Menus\GetMenuUseCase;

class GetMenuInteractor implements GetMenuUseCase
{
    protected $repository;

    public function __construct(MenuRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getByID($menuID)
    {
        $menuStructure = $this->repository->findByID($menuID);

        if (!$menuStructure)
            throw new \Exception('The menu was not found');

        return $menuStructure;
    }

    public function getByIdentifier($menuIdentifier)
    {
        $menuStructure = $this->repository->findByIdentifier($menuIdentifier);

        if (!$menuStructure)
            throw new \Exception('The menu was not found');

        return $menuStructure;
    }

    public function getMenuItemByID($menuID, $menuItemID)
    {
        if ($menuItem = $this->repository->findItemByID($menuID, $menuItemID))
            return $menuItem;

        throw new \Exception('The menu item was not found');
    }
} 