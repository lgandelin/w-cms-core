<?php

namespace CMS\Interactors\Menus;

use CMS\Context;
use CMS\Structures\MenuStructure;

class GetMenusInteractor
{
    public function getAll($langID = null, $structure = false)
    {
        $menus = Context::getRepository('menu')->findAll($langID);

        return ($structure) ? $this->getMenuStructures($menus) : $menus;
    }

    private function getMenuStructures($menus)
    {
        $menuStructures = [];
        if (is_array($menus) && sizeof($menus) > 0) {
            foreach ($menus as $menu) {
                $menuStructures[] = MenuStructure::toStructure($menu);
            }
        }

        return $menuStructures;
    }
}
