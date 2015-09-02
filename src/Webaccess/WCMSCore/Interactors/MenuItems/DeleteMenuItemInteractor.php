<?php

namespace Webaccess\WCMSCore\Interactors\MenuItems;

use Webaccess\WCMSCore\Context;

class DeleteMenuItemInteractor extends GetMenuItemInteractor
{
    public function run($menuItemID)
    {
        if ($this->getMenuItemByID($menuItemID)) {
            Context::get('menu_item')->deleteMenuItem($menuItemID);
        }
    }
}
