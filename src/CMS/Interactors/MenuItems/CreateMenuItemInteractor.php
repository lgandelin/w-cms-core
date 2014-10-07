<?php

namespace CMS\Interactors\MenuItems;

use CMS\Entities\MenuItem;
use CMS\Repositories\MenuItemRepositoryInterface;
use CMS\Structures\MenuItemStructure;

class CreateMenuItemInteractor
{
    private $repository;

    public function __construct(MenuItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(MenuItemStructure $menuItemStructure)
    {
        $menuItem = $this->createFromMenuItemStructure($menuItemStructure);

        if ($menuItem->valid())
            return $this->repository->createMenuItem($menuItem);
    }

    private function createFromMenuItemStructure($menuItemStructure)
    {
        $menuItem = new MenuItem();
        if ($menuItemStructure->label !== null) $menuItem->setLabel($menuItemStructure->label);
        if ($menuItemStructure->page_id !== null) $menuItem->setPageID($menuItemStructure->page_id);
        if ($menuItemStructure->order !== null) $menuItem->setOrder($menuItemStructure->order);
        if ($menuItemStructure->menu_id !== null) $menuItem->setMenuID($menuItemStructure->menu_id);

        return $menuItem;
    }
} 