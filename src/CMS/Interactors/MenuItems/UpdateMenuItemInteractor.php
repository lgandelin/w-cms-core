<?php

namespace CMS\Interactors\MenuItems;

use CMS\Structures\MenuItemStructure;

class UpdateMenuItemInteractor extends GetMenuItemInteractor
{
    public function run($menuItemID, MenuItemStructure $menuItemStructure)
    {
        if ($menuItem = $this->getMenuItemByID($menuItemID)) {
            if (isset($menuItemStructure->label) && $menuItemStructure->label !== null && $menuItem->getLabel() != $menuItemStructure->label) $menuItem->setLabel($menuItemStructure->label);
            if (isset($menuItemStructure->order) && $menuItemStructure->order !== null && $menuItem->getOrder() != $menuItemStructure->order) $menuItem->setOrder($menuItemStructure->order);
            if (isset($menuItemStructure->page_id) && $menuItemStructure->page_id !== null && $menuItem->getPageID() != $menuItemStructure->page_id) $menuItem->setPageID($menuItemStructure->page_id);

            if ($menuItem->valid())
                $this->repository->updateMenuItem($menuItem);
        }
    }
}