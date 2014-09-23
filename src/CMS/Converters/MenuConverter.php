<?php

namespace CMS\Converters;

use CMS\Entities\Menu;
use CMS\Structures\MenuStructure;

class MenuConverter {

    public static function convertMenuToMenuStructure(Menu $menu)
    {
        $items = [];
        if (is_array($menu->getItems())) {
            foreach ($menu->getItems() as $item) {
                $items[]= MenuItemConverter::convertMenuItemToMenuItemStructure($item);
            }
        }

        return new MenuStructure([
            'identifier' => $menu->getIdentifier(),
            'name' => $menu->getName(),
            'items' => $items,
        ]);
    }

    public static function convertMenuStructureToMenu(MenuStructure $menuStructure)
    {
        $menu = new Menu();
        $menu->setIdentifier($menuStructure->identifier);
        $menu->setName($menuStructure->name);

        if (is_array($menuStructure->items)) {
            foreach ($menuStructure->items as $itemStructure) {
                $menu->addItem(MenuItemConverter::convertMenuItemStructureToMenuItem($itemStructure));
            }
        }

        return $menu;
    }
} 