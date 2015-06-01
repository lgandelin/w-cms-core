<?php

namespace CMS\Interactors\Menus;

use CMS\Context;

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

            Context::$menuRepository->updateMenu($menu);
        }
    }

    private function anotherMenuExistsWithSameIdentifier($menuID, $menuIdentifier)
    {
        $existingMenu = Context::$menuRepository->findByIdentifier($menuIdentifier);

        return ($existingMenu && $existingMenu->getID() != $menuID);
    }
}
