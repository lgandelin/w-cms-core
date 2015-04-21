<?php

namespace CMS\Structures;

class MenuStructure extends DataStructure
{
    public $ID;
    public $identifier;
    public $name;
    public $lang_id;

    public static function toStructure($menu)
    {
        $menuStructure = new MenuStructure();
        $menuStructure->ID = $menu->getID();
        $menuStructure->identifier = $menu->getIdentifier();
        $menuStructure->name = $menu->getName();
        $menuStructure->lang_id = $menu->getLangID();

        return $menuStructure;
    }
}
