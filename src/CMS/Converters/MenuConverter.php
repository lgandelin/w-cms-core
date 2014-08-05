<?php

namespace CMS\Converters;

use CMS\Converters\MenuItemConverter;
use CMS\Entities\Menu;
use CMS\Structures\MenuStructure;
use CMS\Repositories\PageRepositoryInterface;

class MenuConverter {

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->menuItemConverter = new MenuItemConverter($pageRepository);
    }

    public function convertMenuToMenuStructure(Menu $menu)
    {
        $items = [];
        if (is_array($menu->getItems())) {
            foreach ($menu->getItems() as $item) {
                $items[]= $this->menuItemConverter->convertMenuItemToMenuItemStructure($item);
            }
        }

        return new MenuStructure([
            'identifier' => $menu->getIdentifier(),
            'name' => $menu->getName(),
            'items' => $items,
        ]);
    }

    public function convertMenuStructureToMenu(MenuStructure $menuStructure)
    {
        $menu = new Menu();
        $menu->setIdentifier($menuStructure->identifier);
        $menu->setName($menuStructure->name);

        if (is_array($menuStructure->items)) {
            foreach ($menuStructure->items as $itemS) {
                $menu->addItem($this->menuItemConverter->convertMenuItemStructureToMenuItem($itemS));
            }
        }

        return $menu;
    }
} 