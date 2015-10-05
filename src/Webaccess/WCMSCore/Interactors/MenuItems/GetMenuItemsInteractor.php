<?php

namespace Webaccess\WCMSCore\Interactors\MenuItems;

use Webaccess\WCMSCore\Context;

class GetMenuItemsInteractor
{
    public function getAll($menuID, $structure = false)
    {
        $menuItems = Context::get('menu_item_repository')->findByMenuID($menuID);

        return ($structure) ? $this->getMenuItemStructures($menuItems) : $menuItems;
    }

    private function getMenuItemStructures($menuItems)
    {
        return array_map(function($menuItem) {
            return $menuItem->toStructure();
        }, $menuItems);
    }
}
