<?php

namespace Webaccess\WCMSCore\Entities\Blocks;

use Webaccess\WCMSCore\Entities\Block;

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
}
