<?php

namespace CMS\Interactors\MenuItems;

use CMS\Context;
use CMS\Structures\MenuItemStructure;

class GetMenuItemsInteractor
{
    public function getAll($menuID, $structure = false)
    {
        $menuItems = Context::$menuItemRepository->findByMenuID($menuID);

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
