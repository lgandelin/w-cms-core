<?php

namespace CMS\Interactors\Menus;

use CMS\Interactors\MenuItems\CreateMenuItemInteractor;
use CMS\Interactors\MenuItems\GetMenuItemsInteractor;
use CMS\Repositories\MenuRepositoryInterface;
use CMS\Structures\MenuItemStructure;
use CMS\Structures\MenuStructure;

class DuplicateMenuInteractor extends GetMenuInteractor
{
    public function __construct(MenuRepositoryInterface $repository, CreateMenuInteractor $createMenuInteractor, GetMenuItemsInteractor $getMenuItemsInteractor, CreateMenuItemInteractor $createMenuItemInteractor)
    {
        parent::__construct($repository);

        $this->createMenuInteractor = $createMenuInteractor;
        $this->getMenuItemsInteractor = $getMenuItemsInteractor;
        $this->createMenuItemInteractor = $createMenuItemInteractor;
    }

    public function run($menuID)
    {
        if ($menu = $this->getMenuByID($menuID)) {
            $newMenuID = $this->duplicateMenu($menu);

            $menuItems = $this->getMenuItemsInteractor->getAll($menuID);
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

        return $this->createMenuInteractor->run(MenuStructure::toStructure($menuDuplicated));
    }

    private function duplicateMenuItem($menuItem, $newMenuID)
    {
        $menuItemStructure = MenuItemStructure::toStructure($menuItem);
        $menuItemStructure->ID = null;
        $menuItemStructure->menu_id = $newMenuID;

        $this->createMenuItemInteractor->run($menuItemStructure);
    }
}
