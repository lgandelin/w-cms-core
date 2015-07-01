<?php

namespace CMS\Interactors\Menus;

use CMS\Context;

class GetMenuInteractor
{
    public function getMenuByID($menuID, $structure = false)
    {
        if (!$menu = Context::get('menu')->findByID($menuID)) {
            throw new \Exception('The menu was not found');
        }

        return ($structure) ? $menu->toStructure() : $menu;
    }
}
