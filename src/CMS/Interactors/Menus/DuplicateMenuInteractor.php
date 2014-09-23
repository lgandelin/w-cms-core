<?php

namespace CMS\Interactors\Menus;

use CMS\UseCases\Menus\DuplicateMenuUseCase;

class DuplicateMenuInteractor extends GetMenuInteractor implements DuplicateMenuUseCase
{
    public function run($menuID)
    {
        if ($menuStructure = $this->getByID($menuID)) {

            $menuStructureDuplicated = clone $menuStructure;
            $menuStructureDuplicated->ID = null;
            $menuStructureDuplicated->name .= ' - COPY';
            $menuStructureDuplicated->identifier .= '-copy';

            $createMenuInteractor = new CreateMenuInteractor($this->repository);
            $createMenuInteractor->run($menuStructureDuplicated);
        }
    }

} 