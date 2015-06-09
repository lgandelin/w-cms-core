<?php

namespace CMS\Interactors\MenuItems;

use CMS\Context;

class DeleteMenuItemInteractor extends GetMenuItemInteractor
{
    public function run($menuItemID)
    {
        if ($this->getMenuItemByID($menuItemID)) {
            Context::getRepository('menu_item')->deleteMenuItem($menuItemID);
        }
    }
}
