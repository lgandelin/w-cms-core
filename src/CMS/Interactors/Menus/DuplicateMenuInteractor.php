<?php

namespace CMS\Interactors\Menus;

use CMS\Interactors\MenuItems\CreateMenuItemInteractor;
use CMS\Interactors\MenuItems\GetMenuItemsInteractor;
use CMS\Structures\MenuItemStructure;
use CMS\Structures\MenuStructure;

class DuplicateMenuInteractor extends GetMenuInteractor
{
    public function run($menuID)
    {
        if ($menu = $this->getMenuByID($menuID)) {
            $newMenuID = $this->duplicateMenu($menu);

            $menuItems = (new GetMenuItemsInteractor())->getAll($menuID);
            foreach ($menuItems as $menuItem) {
                $this->duplicateMenuItem($menuItem, $newMenuID);
            }
        }
    }

    private function duplicateMenu($menu)
    {
        $menuDuplicated = clone $menu;
        $menuDuplicated->setID(null);
        $menuDuplicated->setName($menu->getName() . ' - COPY');
        $menuDuplicated->setIdentifier($menu->getIdentifier() . '-copy');
        $menuDuplicated->setLangID($menu->getLangID());

        return (new CreateMenuInteractor())->run(MenuStructure::toStructure($menuDuplicated));
    }

    private function duplicateMenuItem($menuItem, $newMenuID)
    {
        $menuItemStructure = MenuItemStructure::toStructure($menuItem);
        $menuItemStructure->ID = null;
        $menuItemStructure->menu_id = $newMenuID;

        (new CreateMenuItemInteractor())->run($menuItemStructure);
    }
}
