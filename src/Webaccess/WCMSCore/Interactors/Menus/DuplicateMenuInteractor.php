<?php

namespace Webaccess\WCMSCore\Interactors\Menus;

use Webaccess\WCMSCore\Interactors\MenuItems\CreateMenuItemInteractor;
use Webaccess\WCMSCore\Interactors\MenuItems\GetMenuItemsInteractor;

class DuplicateMenuInteractor extends GetMenuInteractor
{
    public function run($menuID)
    {
        if ($menu = $this->getMenuByID($menuID)) {
            $newMenuID = $this->duplicateMenu($menu);
            $this->duplicateMenuItems($menuID, $newMenuID);
        }
    }

    private function duplicateMenu($menu)
    {
        $menuDuplicated = clone $menu;
        $menuDuplicated->setID(null);
        $menuDuplicated->setName($menu->getName() . ' - COPY');
        $menuDuplicated->setIdentifier($menu->getIdentifier() . '-copy');
        $menuDuplicated->setLangID($menu->getLangID());

        return (new CreateMenuInteractor())->run($menuDuplicated->toStructure());
    }

    private function duplicateMenuItems($menuID, $newMenuID)
    {
        $menuItems = (new GetMenuItemsInteractor())->getAll($menuID);
        foreach ($menuItems as $menuItem) {
            $this->duplicateMenuItem($menuItem, $newMenuID);
        }
    }

    private function duplicateMenuItem($menuItem, $newMenuID)
    {
        $menuItemStructure = $menuItem->toStructure();
        $menuItemStructure->ID = null;
        $menuItemStructure->menu_id = $newMenuID;

        (new CreateMenuItemInteractor())->run($menuItemStructure);
    }
}
