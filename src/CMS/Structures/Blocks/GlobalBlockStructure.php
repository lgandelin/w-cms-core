<?php

namespace CMS\Structures\Blocks;

use CMS\Entities\Blocks\GlobalBlock;
use CMS\Structures\BlockStructure;

class GlobalBlockStructure extends BlockStructure
{
    public $block_reference_id;

    public function getBlock()
    {
        return new GlobalBlock();
    }
}
