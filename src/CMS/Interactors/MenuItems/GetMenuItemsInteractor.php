<?php

namespace CMS\Interactors\MenuItems;

use CMS\Repositories\MenuItemRepositoryInterface;
use CMS\Structures\MenuItemStructure;

class GetMenuItemsInteractor
{
    private $repository;

    public function __construct(MenuItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll($menuID, $structure = false)
    {
        $menuItems = $this->repository->findByMenuID($menuID);

        return ($structure) ? $this->getMenuItemStructures($menuItems) : $menuItems;
    }

    private function getMenuItemStructures($menuItems)
    {
        $menuItemStructures = [];
        if (is_array($menuItems) && sizeof($menuItems) > 0) {
            foreach ($menuItems as $menuItem) {
                $menuItemStructures[] = MenuItemStructure::toStructure($menuItem);
            }
        }

        return $menuItemStructures;
    }
}
