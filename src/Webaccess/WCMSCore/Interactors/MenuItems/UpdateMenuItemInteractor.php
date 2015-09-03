<?php

namespace Webaccess\WCMSCore\Interactors\MenuItems;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;

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
