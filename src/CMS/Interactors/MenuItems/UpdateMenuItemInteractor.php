<?php

namespace CMS\Interactors\MenuItems;

use CMS\Context;
use CMS\Structures\DataStructure;

class UpdateMenuItemInteractor extends GetMenuItemInteractor
{
    public function run($menuItemID, DataStructure $menuItemStructure)
    {
        if ($menuItem = $this->getMenuItemByID($menuItemID)) {
            $menuItem->setInfos($menuItemStructure);
            $menuItem->valid();

            Context::getRepository('menu_item')->updateMenuItem($menuItem);
        }
    }
}
