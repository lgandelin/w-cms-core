<?php

namespace Webaccess\WCMSCore\Interactors\Menus;

use Webaccess\WCMSCore\Context;

class GetMenuInteractor
{
    public function getMenuByID($menuID, $structure = false)
    {
        if (!$menu = Context::get('menu_repository')->findByID($menuID)) {
            throw new \Exception('The menu was not found');
        }

        return ($structure) ? $menu->toStructure() : $menu;
    }
}
