<?php

namespace CMS\Structures;

class MenuStructure extends DataStructure
{
    public $ID;
    public $identifier;
    public $name;

    public static function toStructure($menu)
    {
        $menuStructure = new MenuStructure();
        $menuStructure->ID = $menu->getID();
        $menuStructure->identifier = $menu->getIdentifier();
        $menuStructure->name = $menu->getName();

        return $menuStructure;
    }
}
