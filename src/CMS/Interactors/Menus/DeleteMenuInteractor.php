<?php

namespace CMS\Interactors\Menus;

use CMS\Context;
use CMS\Interactors\MenuItems\DeleteMenuItemInteractor;
use CMS\Interactors\MenuItems\GetMenuItemsInteractor;

class DeleteMenuInteractor extends GetMenuInteractor
{
    public function run($menuID)
    {
        if ($this->getMenuByID($menuID)) {
            $this->deleteMenuItems($menuID);
            Context::getRepository('menu')->deleteMenu($menuID);
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
