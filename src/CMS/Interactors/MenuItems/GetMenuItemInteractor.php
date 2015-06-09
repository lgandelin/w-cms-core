<?php

namespace CMS\Interactors\MenuItems;

use CMS\Context;
use CMS\Structures\MenuItemStructure;

class GetMenuItemInteractor
{
    public function getMenuItemByID($menuItemID, $structure = false)
    {
        if (!$menu = Context::getRepository('menu_item')->findByID($menuItemID)) {
            throw new \Exception('The menu item was not found');
        }

        return ($structure) ? MenuItemStructure::toStructure($menu) : $menu;
    }
}
