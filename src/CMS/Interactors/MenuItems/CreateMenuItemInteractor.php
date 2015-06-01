<?php

namespace CMS\Interactors\MenuItems;

use CMS\Context;
use CMS\Entities\MenuItem;
use CMS\Structures\MenuItemStructure;

class CreateMenuItemInteractor
{
    public function run(MenuItemStructure $menuItemStructure)
    {
        $menuItem = new MenuItem();
        $menuItem->setInfos($menuItemStructure);
        $menuItem->valid();

        return Context::$menuItemRepository->createMenuItem($menuItem);
    }
}
