<?php

namespace CMS\Structures\Blocks;

use CMS\Entities\Blocks\HTMLBlock;
use CMS\Structures\DataStructure;

class HTMLBlockStructure extends DataStructure
{
    public $html;

    public function getBlock()
    {
        return new HTMLBlock();
    }
}
