<?php

namespace Webaccess\WCMSCore\Entities\Blocks;

use Webaccess\WCMSCore\Entities\Block;
use Webaccess\WCMSCore\Interactors\MenuItems\GetMenuItemsInteractor;
use Webaccess\WCMSCore\Interactors\Menus\GetMenuInteractor;
use Webaccess\WCMSCore\Interactors\Pages\GetPageInteractor;

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
