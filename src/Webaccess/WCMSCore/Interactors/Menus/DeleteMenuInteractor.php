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
            Context::get('menu_repository')->deleteMenu($menuID);
        }
    }

    private function deleteMenuItems($menuID)
    {
        array_map(function($menuItem) {
            (new DeleteMenuItemInteractor())->run($menuItem->getID());
        }, (new GetMenuItemsInteractor())->getAll($menuID));
    }
}
