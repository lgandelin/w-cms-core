<?php

namespace Webaccess\WCMSCore\Interactors\MenuItems;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Structures\MenuItemStructure;

class GetMenuItemInteractor
{
    public function getMenuItemByID($menuItemID, $structure = false)
    {
        if (!$menu = Context::get('menu_item')->findByID($menuItemID)) {
            throw new \Exception('The menu item was not found');
        }

        return ($structure) ? $menu->toStructure() : $menu;
    }
}
