<?php

namespace CMS\Interactors\Menus;

class DeleteMenuInteractor extends GetMenuInteractor
{
    public function run($menuID)
    {
        if ($this->getMenuByID($menuID))
            $this->repository->deleteMenu($menuID);
    }
}