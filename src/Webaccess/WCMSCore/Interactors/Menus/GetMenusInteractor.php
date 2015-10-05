<?php

namespace Webaccess\WCMSCore\Interactors\Menus;

use Webaccess\WCMSCore\Context;

class GetMenusInteractor
{
    public function getAll($langID = null, $structure = false)
    {
        $menus = Context::get('menu_repository')->findAll($langID);

        return ($structure) ? $this->getMenuStructures($menus) : $menus;
    }

    private function getMenuStructures($menus)
    {
        return array_map(function($menu) {
            return $menu->toStructure();
        }, $menus);
    }
}
