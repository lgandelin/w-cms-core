<?php

namespace Webaccess\WCMSCore\Interactors\Menus;

use Webaccess\WCMSCore\Context;

class GetMenusInteractor
{
    public function getAll($langID = null, $structure = false)
    {
        $menus = Context::get('menu')->findAll($langID);

        return ($structure) ? $this->getMenuStructures($menus) : $menus;
    }

    private function getMenuStructures($menus)
    {
        $menuStructures = [];
        if (is_array($menus) && sizeof($menus) > 0) {
            foreach ($menus as $menu) {
                $menuStructures[] = $menu->toStructure();
            }
        }

        return $menuStructures;
    }
}
