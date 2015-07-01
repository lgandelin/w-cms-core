<?php

namespace CMS\Interactors\MenuItems;

use CMS\Context;
use CMS\DataStructure;

class UpdateMenuItemInteractor extends GetMenuItemInteractor
{
    public function run($menuItemID, DataStructure $menuItemStructure)
    {
        if ($menuItem = $this->getMenuItemByID($menuItemID)) {
            $menuItem->setInfos($menuItemStructure);
            $menuItem->valid();

            Context::get('menu_item')->updateMenuItem($menuItem);
        }
    }
}
