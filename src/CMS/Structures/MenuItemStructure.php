<?php

namespace CMS\Structures;

use CMS\Entities\MenuItem;
use CMS\Structures\DataStructure;

class MenuItemStructure extends DataStructure {

    public $label;
    public $page;
    public $order;

    public static function convertMenuItemToMenuItemStructure(MenuItem $item)
    {
        return new MenuItemStructure([
            'label' => $item->getLabel(),
            'order' => $item->getOrder(),
            'page' => ($item->getPage()) ? PageStructure::convertPageToPageStructure($item->getPage) : null
        ]);
    }

    public static function convertMenuItemStructureToMenuItem($itemS)
    {
        $item = new MenuItem();
        $item->setLabel($itemS->label);
        $item->setOrder($itemS->order);
        if ($itemS->page) {
            $page = PageStructure::convertPageStructureToPage($itemS->page);
            $item->setPage($page);
        }

        return $item;
    }
}