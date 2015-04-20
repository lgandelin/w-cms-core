<?php

namespace CMS\Structures;

use CMS\Entities\Lang;

class LangStructure extends DataStructure
{
    public $ID;
    public $name;
    public $prefix;
    public $is_default;

    public static function toStructure(Lang $lang)
    {
        $langStructure = new LangStructure();
        $langStructure->ID = $lang->getID();
        $langStructure->name = $lang->getName();
        $langStructure->prefix = $lang->getPrefix();
        $langStructure->is_default = $lang->getIsDefault();

        return $langStructure;
    }
}
