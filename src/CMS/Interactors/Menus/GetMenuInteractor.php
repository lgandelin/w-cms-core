<?php

namespace CMS\Interactors\Menus;

use CMS\Context;
use CMS\Structures\MenuStructure;

class GetMenuInteractor
{
    public function getMenuByID($menuID, $structure = false)
    {
        if (!$menu = Context::$menuRepository->findByID($menuID)) {
            throw new \Exception('The menu was not found');
        }

        return ($structure) ? MenuStructure::toStructure($menu) : $menu;
    }
}
