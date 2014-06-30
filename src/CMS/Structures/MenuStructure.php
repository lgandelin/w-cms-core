<?php

namespace CMS\Structures;

use CMS\Entities\Menu;
use CMS\Entities\MenuItem;
use CMS\Structures\DataStructure;

class MenuStructure extends DataStructure {

    public $identifier;
    public $items;
    public $name;

    public static function convertMenuToMenuStructure(Menu $menu)
    {
        $items = [];
        if (is_array($menu->getItems())) {
            foreach ($menu->getItems() as $item) {
                $items[]= MenuItemStructure::convertMenuItemToMenuItemStructure($item);
            }
        }

        return new MenuStructure([
            'identifier' => $menu->getIdentifier(),
            'items' => $items,
            'name' => $menu->getName()
        ]);
    }

    public static function convertMenuStructureToMenu(MenuStructure $menuStructure)
    {
        $menu = new Menu();
        $menu->setIdentifier($menuStructure->identifier);
        $menu->setName($menuStructure->name);

        if (is_array($menuStructure->items)) {
            foreach ($menuStructure->items as $itemS) {
                $menu->addItem(MenuItemStructure::convertMenuItemStructureToMenuItem($itemS));
            }
        }

        return $menu;
    }
}