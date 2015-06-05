<?php

namespace CMS\Structures\Blocks;

use CMS\Entities\Blocks\ViewBlock;
use CMS\Structures\BlockStructure;

class ViewBlockStructure extends BlockStructure
{
    public $view_path;

    public function getBlock()
    {
        return new ViewBlock();
    }
}
