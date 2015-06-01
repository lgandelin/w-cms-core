<?php

namespace CMS\Interactors\MenuItems;

use CMS\Context;
use CMS\Structures\MenuItemStructure;

class UpdateMenuItemInteractor extends GetMenuItemInteractor
{
    public function run($menuItemID, MenuItemStructure $menuItemStructure)
    {
        if ($menuItem = $this->getMenuItemByID($menuItemID)) {
            $menuItem->setInfos($menuItemStructure);
            $menuItem->valid();

            Context::$menuItemRepository->updateMenuItem($menuItem);
        }
    }
}
