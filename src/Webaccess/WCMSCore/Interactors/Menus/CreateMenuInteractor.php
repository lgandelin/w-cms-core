<?php

namespace Webaccess\WCMSCore\Interactors\Menus;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Menu;
use Webaccess\WCMSCore\DataStructure;

class CreateMenuInteractor
{
    public function run(DataStructure $menuStructure)
    {
        $menu = (new Menu())->setInfos($menuStructure);
        $menu->valid();

        if ($this->anotherExistingMenuWithSameIdentifier($menu->getIdentifier())) {
            throw new \Exception('There is already a menu with the same identifier');
        }

        return Context::get('menu_repository')->createMenu($menu);
    }

    private function anotherExistingMenuWithSameIdentifier($identifier)
    {
        return Context::get('menu_repository')->findByIdentifier($identifier);
    }
}
