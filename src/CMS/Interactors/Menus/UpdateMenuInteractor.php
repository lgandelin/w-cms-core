<?php

namespace CMS\Interactors\Menus;

use CMS\Converters\MenuConverter;

class UpdateMenuInteractor extends GetMenuInteractor
{
    public function run($menuID, $menuStructure)
    {
        if ($originalMenuStructure = $this->getByID($menuID)) {
            $menuUpdated = $this->getMenuUpdated($originalMenuStructure, $menuStructure);

            if ($menuUpdated->valid()) {
                if ($this->anotherMenuExistsWithSameIdentifier($menuID, $menuUpdated->getIdentifier()))
                    throw new \Exception('There is already a menu with the same identifier');

                $this->repository->updateMenu($menuID, MenuConverter::convertMenuToMenuStructure($menuUpdated));
            }
        }
    }

    public function getMenuUpdated($originalMenuStructure, $menuStructure)
    {
        $menu = MenuConverter::convertMenuStructureToMenu($originalMenuStructure);

        if (isset($menuStructure->name) && $menuStructure->name !== null && $menu->getName() != $menuStructure->name) $menu->setName($menuStructure->name);
        if (isset($menuStructure->identifier) && $menuStructure->identifier !== null && $menu->getIdentifier() != $menuStructure->identifier) $menu->setIdentifier($menuStructure->identifier);

        return $menu;
    }

    public function anotherMenuExistsWithSameIdentifier($menuID, $menuIdentifier)
    {
        $existingMenuStructure = $this->repository->findByIdentifier($menuIdentifier);

        return ($existingMenuStructure && $existingMenuStructure->ID != $menuID);
    }
} 