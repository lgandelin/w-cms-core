<?php

namespace Webaccess\WCMSCore\Interactors\MenuItems;

use Webaccess\WCMSCore\Context;

class GetMenuItemInteractor
{
    public function getMenuItemByID($menuItemID, $structure = false)
    {
        if (!$menu = Context::get('menu_item_repository')->findByID($menuItemID)) {
            throw new \Exception('The menu item was not found');
        }

        return ($structure) ? $menu->toStructure() : $menu;
    }
}
