<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;
use CMS\Structures\Blocks\MenuBlockStructure;

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
}
