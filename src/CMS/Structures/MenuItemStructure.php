<?php

namespace CMS\Structures;

class MenuItemStructure extends DataStructure
{
    public $ID;
    public $label;
    public $page_id;
    public $external_url;
    public $order;
    public $class;
    public $menu_id;
    public $display;

    public static function toStructure($menuItem)
    {
        $menuItemStructure = new MenuItemStructure();
        $menuItemStructure->ID = $menuItem->getID();
        $menuItemStructure->label = $menuItem->getLabel();
        $menuItemStructure->page_id = $menuItem->getPageID();
        $menuItemStructure->external_url = $menuItem->getExternalURL();
        $menuItemStructure->order = $menuItem->getOrder();
        $menuItemStructure->menu_id = $menuItem->getMenuID();
        $menuItemStructure->class = $menuItem->getClass();
        $menuItemStructure->display = $menuItem->getDisplay();

        return $menuItemStructure;
    }
}
