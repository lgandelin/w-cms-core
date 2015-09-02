<?php

namespace Webaccess\WCMSCore\Interactors\Menus;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\MenuItems\DeleteMenuItemInteractor;
use Webaccess\WCMSCore\Interactors\MenuItems\GetMenuItemsInteractor;

class DeleteMenuInteractor extends GetMenuInteractor
{
    public function run($menuID)
    {
        if ($this->getMenuByID($menuID)) {
            $this->deleteMenuItems($menuID);
            Context::get('menu')->deleteMenu($menuID);
        }
    }

    private function deleteMenuItems($menuID)
    {
        $menuItems = (new GetMenuItemsInteractor())->getAll($menuID);

        foreach ($menuItems as $menuItem) {
            (new DeleteMenuItemInteractor())->run($menuItem->getID());
        }
    }
}
