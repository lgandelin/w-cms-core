<?php

namespace CMS\Interactors\Menus;

use CMS\Context;

class UpdateMenuInteractor extends GetMenuInteractor
{
    public function run($menuID, $menuStructure)
    {
        if ($menu = $this->getMenuByID($menuID)) {
            if (
                isset($menuStructure->name) &&
                $menuStructure->name !== null &&
                $menu->getName() != $menuStructure->name
            ) {
                $menu->setName($menuStructure->name);
            }
            if (
                isset($menuStructure->identifier) &&
                $menuStructure->identifier !== null &&
                $menu->getIdentifier() != $menuStructure->identifier
            ) {
                $menu->setIdentifier($menuStructure->identifier);
            }

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
