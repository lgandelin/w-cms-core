<?php

namespace CMS\Interactors\Menus;

use CMS\Context;
use CMS\Entities\Menu;
use CMS\Structures\MenuStructure;

class CreateMenuInteractor
{
    public function run(MenuStructure $menuStructure)
    {
        $menu = $this->createMenuFromStructure($menuStructure);

        $menu->valid();

        if ($this->anotherExistingMenuWithSameIdentifier($menu->getIdentifier())) {
            throw new \Exception('There is already a menu with the same identifier');
        }

        return Context::$menuRepository->createMenu($menu);
    }

    private function anotherExistingMenuWithSameIdentifier($identifier)
    {
        return Context::$menuRepository->findByIdentifier($identifier);
    }

    private function createMenuFromStructure(MenuStructure $menuStructure)
    {
        $menu = new Menu();
        $menu->setIdentifier($menuStructure->identifier);
        $menu->setName($menuStructure->name);
        $menu->setLangID($menuStructure->lang_id);

        return $menu;
    }
}
