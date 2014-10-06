<?php

namespace CMS\Structures;

class MenuItemStructure extends DataStructure
{
    public $ID;
    public $label;
    public $page_id;
    public $order;
    public $menu_id;

    public static function toStructure($menuItem)
    {
        $menuItemStructure = new MenuItemStructure();
        $menuItemStructure->ID = $menuItem->getID();
        $menuItemStructure->label = $menuItem->getLabel();
        $menuItemStructure->page_id = $menuItem->getPageID();
        $menuItemStructure->order = $menuItem->getOrder();
        $menuItemStructure->menu_id = $menuItem->getMenuID();

        return $menuItemStructure;
    }
}