<?php

namespace Webaccess\WCMSCoreTests\Repositories;

use Webaccess\WCMSCore\Entities\MenuItem;
use Webaccess\WCMSCore\Repositories\MenuItemRepositoryInterface;

class InMemoryMenuItemRepository implements MenuItemRepositoryInterface
{
    private $menuItems;

    public function __construct()
    {
        $this->menuItems = [];
    }

    public function createMenuItem(MenuItem $menuItem)
    {
        $menuItemID = sizeof($this->menuItems) + 1;
        $menuItem->setID($menuItemID);
        $this->menuItems[]= $menuItem;

        return $menuItemID;
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

    public function findAll($langID = null)
    {
        return $this->menuItems;
    }
}
