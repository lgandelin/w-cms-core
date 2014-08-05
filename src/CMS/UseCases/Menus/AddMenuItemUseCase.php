<?php

namespace CMS\UseCases\Menus;

use CMS\Structures\MenuItemStructure;

interface AddMenuItemUseCase
{
    public function run($menuID, MenuItemStructure $menuItemStructure);
}