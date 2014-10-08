<?php

namespace CMS\Interactors\Menus;

class DuplicateMenuInteractor extends GetMenuInteractor
{
    public function run($menuID)
    {
        if ($menu = $this->getMenuByID($menuID, true)) {
            $menuDuplicated = clone $menu;
            $menuDuplicated->id = null;
            $menuDuplicated->name = $menu->name . ' - COPY';
            $menuDuplicated->identifier = $menu->identifier . '-copy';

            return $this->getCreateMenuInteractor()->run($menuDuplicated);
        }
    }

    private function getCreateMenuInteractor()
    {
        return new CreateMenuInteractor($this->repository);
    }
} 