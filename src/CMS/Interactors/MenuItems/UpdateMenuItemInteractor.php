<?php

namespace CMS\Interactors\MenuItems;

use CMS\Structures\MenuItemStructure;

class UpdateMenuItemInteractor extends GetMenuItemInteractor
{
    public function run($menuItemID, MenuItemStructure $menuItemStructure)
    {
        if ($menuItem = $this->getMenuItemByID($menuItemID)) {
            $properties = get_object_vars($menuItemStructure);
            unset ($properties['ID']);
            foreach ($properties as $property => $value) {
                $method = ucfirst(str_replace('_', '', $property));
                $setter = 'set' . $method;

                if ($menuItemStructure->$property !== null) {
                    call_user_func_array(array($menuItem, $setter), array($value));
                }
            }

            $menuItem->valid();

            $this->repository->updateMenuItem($menuItem);
        }
    }
}
