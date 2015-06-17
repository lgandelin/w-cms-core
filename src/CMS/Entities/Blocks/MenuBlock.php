<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;
use CMS\Interactors\MenuItems\GetMenuItemsInteractor;
use CMS\Interactors\Menus\GetMenuInteractor;
use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Structures\Blocks\MenuBlockStructure;
use CMS\Structures\BlockStructure;

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

    public function getStructure()
    {
        $blockStructure = new MenuBlockStructure();
        $blockStructure->menu_id = $this->getMenuID();

        return $blockStructure;
    }

    public function updateContent(BlockStructure $blockStructure)
    {
        if ($blockStructure->menuID !== null && $blockStructure->menuID != $this->getMenuID()) {
            $this->setMenuID($blockStructure->menuID);
        }
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
