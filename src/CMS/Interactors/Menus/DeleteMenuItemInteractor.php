<?php

namespace CMS\Interactors\Menus;

use CMS\Converters\MenuConverter;
use CMS\Converters\MenuItemConverter;

class DeleteMenuItemInteractor extends GetMenuInteractor {

    public function run($menuID, $menuItemID)
    {
        if ($menuStructure = $this->getByID($menuID)) {
            if ($menuItemStructure = $this->getMenuItemByID($menuID, $menuItemID)) {
                $menu = MenuConverter::convertMenuStructureToMenu($menuStructure);
                $menuItem = MenuItemConverter::convertMenuItemStructureToMenuItem($menuItemStructure);

                $menu->deleteItem($menuItem->getID());
                $this->repository->deleteItem($menuID, $menuItem->getId());
            }
        }
    }
}