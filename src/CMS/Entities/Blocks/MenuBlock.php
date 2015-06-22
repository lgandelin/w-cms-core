<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;
use CMS\Interactors\MenuItems\GetMenuItemsInteractor;
use CMS\Interactors\Menus\GetMenuInteractor;
use CMS\Interactors\Pages\GetPageInteractor;

class MenuBlock extends Block
{
    private $menuID;

    public function setMenuID($menuID)
    {
        $this->menuID = $menuID;
    }

    public function getMenuID()
    {
        return $this->menuID;
    }

    public function getContentData()
    {
        if ($this->getMenuID()) {
            $content = (new GetMenuInteractor())->getMenuByID($this->getMenuID(), true);
            $menuItems = (new GetMenuItemsInteractor())->getAll($this->getMenuID(), true);

            foreach ($menuItems as $menuItem)
                if (isset($menuItem->pageID))
                    $menuItem->page = (new GetPageInteractor())->getPageByID($menuItem->pageID, true);

            $content->items = $menuItems;

            return $content;
        }

        return null;
    }
}
