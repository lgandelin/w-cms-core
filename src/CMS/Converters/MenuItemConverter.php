<?php

namespace CMS\Converters;

use CMS\Entities\MenuItem;
use CMS\Entities\Page;
use CMS\Structures\MenuItemStructure;

class MenuItemConverter {

    public static function convertMenuItemToMenuItemStructure(MenuItem $item)
    {
        return new MenuItemStructure([
            'ID' => $item->getID(),
            'label' => $item->getLabel(),
            'order' => $item->getOrder(),
            'page_id' => ($item->getPage() instanceof Page) ? $item->getPage()->getID() : null
        ]);
    }

    public static function convertMenuItemStructureToMenuItem($itemS)
    {
        $item = new MenuItem();
        $item->setID($itemS->ID);
        $item->setLabel($itemS->label);
        $item->setOrder($itemS->order);

        return $item;
    }
} 