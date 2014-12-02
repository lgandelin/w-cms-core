<?php

namespace CMS\Interactors\MenuItems;

class DeleteMenuItemInteractor extends GetMenuItemInteractor
{
    public function run($menuItemID)
    {
        if ($this->getMenuItemByID($menuItemID)) {
            $this->repository->deleteMenuItem($menuItemID);
        }
    }
}
