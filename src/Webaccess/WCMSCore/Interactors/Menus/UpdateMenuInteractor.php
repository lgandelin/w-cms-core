<?php

namespace Webaccess\WCMSCore\Interactors\Menus;

use Webaccess\WCMSCore\Context;

class UpdateMenuInteractor extends GetMenuInteractor
{
    public function run($menuID, $menuStructure)
    {
        if ($menu = $this->getMenuByID($menuID)) {
            $menu->setInfos($menuStructure);
            $menu->valid();

            if ($this->anotherMenuExistsWithSameIdentifier($menuID, $menu->getIdentifier())) {
                throw new \Exception('There is already a menu with the same identifier');
            }

            Context::get('menu')->updateMenu($menu);
        }
    }

    private function anotherMenuExistsWithSameIdentifier($menuID, $menuIdentifier)
    {
        $existingMenu = Context::get('menu')->findByIdentifier($menuIdentifier);

        return ($existingMenu && $existingMenu->getID() != $menuID);
    }
}
