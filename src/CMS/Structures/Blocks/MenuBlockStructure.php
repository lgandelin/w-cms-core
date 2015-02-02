<?php

namespace CMS\Structures\Blocks;

use CMS\Entities\Blocks\MenuBlock;
use CMS\Structures\BlockStructure;

class MenuBlockStructure extends BlockStructure
{
    public $menu_id;

    public function getBlock()
    {
        return new MenuBlock();
    }
}
