<?php

namespace CMS\Repositories\InMemory;

use CMS\Repositories\MenuRepositoryInterface;
use CMS\Structures\MenuItemStructure;
use CMS\Structures\MenuStructure;

class InMemoryMenuRepository implements MenuRepositoryInterface {

    private $menus;

    public function __construct()
    {
        $this->menus = [];
    }

    public function findByID($menuID)
    {
        foreach ($this->menus as $menu) {
            if ($menu->ID == $menuID)
                return $menu;
        }

        return false;
    }

    public function findByIdentifier($menuIdentifier)
    {
        foreach ($this->menus as $menu) {
            if ($menu->identifier == $menuIdentifier)
                return $menu;
        }

        return false;
    }

    public function findAll()
    {
        return $this->menus;
    }

    public function createMenu(MenuStructure $menuStructure)
    {
        $this->menus[]= $menuStructure;
    }

    public function updateMenu($menuID, MenuStructure $menuStructure)
    {
        foreach ($this->menus as $i => $menu) {
            if ($menu->ID == $menuID) {
                $menu->name = $menuStructure->name;
                $menu->identifier = $menuStructure->identifier;
            }
        }
    }

    public function deleteMenu($menuID)
    {
        foreach ($this->menus as $i => $menu) {
            if ($menu->ID == $menuID) {
                unset($this->menus[$i]);
            }
        }
    }

    public function findItemByID($menuID, $menuItemID)
    {
        if ($menu = $this->findByID($menuID)) {
            if (is_array($menu->items) && sizeof($menu->items) > 0) {
                foreach ($menu->items as $menuItem) {
                    if ($menuItem->ID == $menuItemID)
                        return $menuItem;
                }
            }
        }

        return false;
    }

    public function addItem($menuID, MenuItemStructure $menuItemStructure)
    {
        foreach ($this->menus as $menu) {
            if ($menu->ID == $menuID) {
                $menu->items[$menuItemStructure->ID]= $menuItemStructure;
            }
        }
    }

    public function updateItem($menuID, $menuItemID, MenuItemStructure $menuItemStructure)
    {
        foreach ($this->menus as $menu) {
            if ($menu->ID == $menuID) {
                if ($this->findItemByID($menuID, $menuItemID)) {
                    $menuItemStructureUpdated = $menu->items[$menuItemID];

                    if ($menuItemStructure->label != null) $menuItemStructureUpdated->label = $menuItemStructure->label;
                    if ($menuItemStructure->order != null) $menuItemStructureUpdated->order = $menuItemStructure->order;

                    $menu->items[$menuItemID] = $menuItemStructureUpdated;
                }
            }
        }
    }

    public function deleteItem($menuID, $menuItemID)
    {
        foreach ($this->menus as $i => $menu) {
            if ($menu->ID == $menuID) {
                unset($this->menus[$i]->items[$menuItemID]);
            }
        }
    }


}