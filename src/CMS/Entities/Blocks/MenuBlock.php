<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;

class MenuBlock extends Block {

    private $menuID;

    public function setMenuID($menuID)
    {
        $this->menuID = $menuID;
    }

    public function getMenuID()
    {
        return $this->menuID;
    }

}