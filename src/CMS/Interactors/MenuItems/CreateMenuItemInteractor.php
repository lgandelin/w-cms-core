<?php

namespace CMS\Interactors\MenuItems;

use CMS\Context;
use CMS\Entities\MenuItem;
use CMS\Structures\MenuItemStructure;

class CreateMenuItemInteractor
{
    public function run(MenuItemStructure $menuItemStructure)
    {
        $menuItem = $this->createFromMenuItemStructure($menuItemStructure);

        $menuItem->valid();

        return Context::$menuItemRepository->createMenuItem($menuItem);
    }

    private function createFromMenuItemStructure($menuItemStructure)
    {
        $menuItem = new MenuItem();
        if ($menuItemStructure->label !== null) {
            $menuItem->setLabel($menuItemStructure->label);
        }
        if ($menuItemStructure->order !== null) {
            $menuItem->setOrder($menuItemStructure->order);
        }
        if ($menuItemStructure->page_id !== null) {
            $menuItem->setPageID($menuItemStructure->page_id);
        }
        if ($menuItemStructure->external_url !== null) {
            $menuItem->setExternalURL($menuItemStructure->external_url);
        }
        if ($menuItemStructure->class !== null) {
            $menuItem->setClass($menuItemStructure->class);
        }
        if ($menuItemStructure->menu_id !== null) {
            $menuItem->setMenuID($menuItemStructure->menu_id);
        }
        if ($menuItemStructure->display !== null) {
            $menuItem->setDisplay($menuItemStructure->display);
        }

        return $menuItem;
    }
}
