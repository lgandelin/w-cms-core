<?php

namespace CMS\Structures\Blocks;

use CMS\Entities\Blocks\HTMLBlock;
use CMS\Structures\BlockStructure;

class HTMLBlockStructure extends BlockStructure
{
    public $html;

    public function getBlock()
    {
        return new HTMLBlock();
    }
}
