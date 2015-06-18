<?php

namespace CMS\Structures\Blocks;

use CMS\Entities\Blocks\GlobalBlock;
use CMS\Structures\DataStructure;

class GlobalBlockStructure extends DataStructure
{
    public $block_reference_id;

    public function getBlock()
    {
        return new GlobalBlock();
    }
}
