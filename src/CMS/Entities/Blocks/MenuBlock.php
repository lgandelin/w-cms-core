<?php

namespace CMS\Entities\Blocks;

use CMS\Context;
use CMS\Entities\Block;
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

    public function getContentData()
    {
        return Context::$menuItemRepository->findByMenuID($this->menuID);
    }

    public function updateContent(BlockStructure $blockStructure)
    {
        if ($blockStructure->menu_id !== null && $blockStructure->menu_id != $this->getMenuID()) {
            $this->setMenuID($blockStructure->menu_id);
        }
    }
}
