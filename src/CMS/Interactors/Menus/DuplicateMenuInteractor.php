<?php

namespace CMS\Interactors\Menus;

class DuplicateMenuInteractor extends GetMenuInteractor
{
    public function run($menuID)
    {
        if ($menu = $this->getByID($menuID)) {
            $menuDuplicated = clone $menu;
            $menuDuplicated->setID(null);
            $menuDuplicated->setName($menu->getName() . ' - COPY');
            $menuDuplicated->setIdentifier($menu->getIdentifier() . '-copy');

            return $this->getCreateMenuInteractor()->run($menuDuplicated);
        }
    }

    private function getCreateMenuInteractor()
    {
        return new CreateMenuInteractor($this->repository);
    }
} 