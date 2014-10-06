<?php

namespace CMS\Interactors\Menus;

class UpdateMenuInteractor extends GetMenuInteractor
{
    public function run($menuID, $menuStructure)
    {
        if ($menu = $this->getMenuByID($menuID)) {

            if (isset($menuStructure->name) && $menuStructure->name !== null && $menu->getName() != $menuStructure->name) $menu->setName($menuStructure->name);
            if (isset($menuStructure->identifier) && $menuStructure->identifier !== null && $menu->getIdentifier() != $menuStructure->identifier) $menu->setIdentifier($menuStructure->identifier);

            if ($menu->valid()) {
                if ($this->anotherMenuExistsWithSameIdentifier($menuID, $menu   ->getIdentifier()))
                    throw new \Exception('There is already a menu with the same identifier');

                $this->repository->updateMenu($menu);
            }
        }
    }

    private function anotherMenuExistsWithSameIdentifier($menuID, $menuIdentifier)
    {
        $existingMenu = $this->repository->findByIdentifier($menuIdentifier);

        return ($existingMenu && $existingMenu->getID() != $menuID);
    }
}