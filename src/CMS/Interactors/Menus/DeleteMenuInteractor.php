<?php

namespace CMS\Interactors\Menus;

use CMS\UseCases\Menus\DeleteMenuUseCase;

class DeleteMenuInteractor extends GetMenuInteractor implements DeleteMenuUseCase
{
    public function run($menuID)
    {
        if ($this->getByID($menuID))
            $this->repository->deleteMenu($menuID);
    }

}