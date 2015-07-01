<?php

namespace CMS\Interactors\MenuItems;

use CMS\Context;
use CMS\Entities\MenuItem;
use CMS\DataStructure;

class CreateMenuItemInteractor
{
    public function run(DataStructure $menuItemStructure)
    {
        $menuItem = new MenuItem();
        $menuItem->setInfos($menuItemStructure);
        $menuItem->valid();

        return Context::get('menu_item')->createMenuItem($menuItem);
    }
}
