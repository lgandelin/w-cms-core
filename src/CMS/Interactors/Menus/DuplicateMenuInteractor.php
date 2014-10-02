<?php

namespace CMS\Interactors\Menus;

class DuplicateMenuInteractor extends GetMenuInteractor
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