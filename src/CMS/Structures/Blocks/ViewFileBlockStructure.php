<?php

namespace CMS\Structures\Blocks;

use CMS\Entities\Blocks\ViewFileBlock;
use CMS\Structures\BlockStructure;

class ViewFileBlockStructure extends BlockStructure
{
    public $view_file;

    public function getBlock()
    {
        return new ViewFileBlock();
    }
}
