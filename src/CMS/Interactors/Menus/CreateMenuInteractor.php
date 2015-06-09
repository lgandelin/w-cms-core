<?php

namespace CMS\Interactors\Menus;

use CMS\Context;
use CMS\Entities\Menu;
use CMS\Structures\MenuStructure;

class CreateMenuInteractor
{
    public function run(MenuStructure $menuStructure)
    {
        $menu = new Menu();
        $menu->setInfos($menuStructure);
        $menu->valid();

        if ($this->anotherExistingMenuWithSameIdentifier($menu->getIdentifier())) {
            throw new \Exception('There is already a menu with the same identifier');
        }

        return Context::getRepository('menu')->createMenu($menu);
    }

    private function anotherExistingMenuWithSameIdentifier($identifier)
    {
        return Context::getRepository('menu')->findByIdentifier($identifier);
    }
}
