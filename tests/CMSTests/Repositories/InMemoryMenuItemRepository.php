<?php

namespace CMSTests\Repositories;

use CMS\Entities\MenuItem;
use CMS\Repositories\MenuItemRepositoryInterface;

class InMemoryMenuItemRepository implements MenuItemRepositoryInterface
{
    private $menuItems;

    public function __construct()
    {
        $this->menuItems = [];
    }

    public function createMenuItem(MenuItem $menuItem)
    {
        $this->menuItems[]= $menuItem;
    }

    public function updateMenuItem(MenuItem $menuItem)
    {
        foreach ($this->menuItems as $menuItemModel) {
            if ($menuItemModel->getID() == $menuItem->getID()) {
            }
        }
    }

    public function deleteMenuItem($menuItemID)
    {
        foreach ($this->menuItems as $i => $menuItem) {
            if ($menuItem->getID() == $menuItemID) {
                unset($this->menuItems[$i]);
            }
        }
    }

    public function findByID($menuItemID)
    {
        foreach ($this->menuItems as $menuItem) {
            if ($menuItem->getID() == $menuItemID) {
                return $menuItem;
            }
        }

        return false;
    }

    public function findByMenuID($menuID)
    {
        $menuItems = [];

        foreach ($this->menuItems as $menuItem) {
            if ($menuItem->getMenuID() == $menuID) {
                $menuItems[]= $menuItem;
            }
        }

        return $menuItems;
    }
}
