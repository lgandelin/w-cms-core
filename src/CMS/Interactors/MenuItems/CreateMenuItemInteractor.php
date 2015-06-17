<?php

namespace CMS\Interactors\MenuItems;

use CMS\Context;
use CMS\Entities\MenuItem;
use CMS\Structures\DataStructure;

class CreateMenuItemInteractor
{
    public function run(DataStructure $menuItemStructure)
    {
        $menuItem = new MenuItem();
        $menuItem->setInfos($menuItemStructure);
        $menuItem->valid();

        return Context::getRepository('menu_item')->createMenuItem($menuItem);
    }
}
