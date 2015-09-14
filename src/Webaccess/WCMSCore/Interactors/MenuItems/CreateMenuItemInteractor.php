<?php

namespace Webaccess\WCMSCore\Interactors\MenuItems;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\MenuItem;
use Webaccess\WCMSCore\DataStructure;

class CreateMenuItemInteractor
{
    public function run(DataStructure $menuItemStructure)
    {
        $menuItem = new MenuItem();
        $menuItem->setInfos($menuItemStructure);
        $menuItem->valid();

        return Context::get('menu_item_repository')->createMenuItem($menuItem);
    }
}
