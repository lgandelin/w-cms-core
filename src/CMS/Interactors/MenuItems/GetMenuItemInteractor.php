<?php

namespace CMS\Interactors\MenuItems;

use CMS\Repositories\MenuItemRepositoryInterface;
use CMS\Structures\MenuItemStructure;

class GetMenuItemInteractor
{
    protected $repository;

    public function __construct(MenuItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getMenuItemByID($menuItemID, $structure = false)
    {
        if (!$menu = $this->repository->findByID($menuItemID))
            throw new \Exception('The menu item was not found');

        return ($structure) ? MenuItemStructure::toStructure($menu) : $menu;
    }
} 