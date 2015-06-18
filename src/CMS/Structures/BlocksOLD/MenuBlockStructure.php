<?php

namespace CMS\Structures\Blocks;

use CMS\Entities\Blocks\MenuBlock;
use CMS\Structures\DataStructure;

class MenuBlockStructure extends DataStructure
{
    public $menu_id;

    public function getBlock()
    {
        return new MenuBlock();
    }
}
