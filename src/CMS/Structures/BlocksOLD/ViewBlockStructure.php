<?php

namespace CMS\Structures\Blocks;

use CMS\Entities\Blocks\ViewBlock;
use CMS\Structures\DataStructure;

class ViewBlockStructure extends DataStructure
{
    public $view_path;

    public function getBlock()
    {
        return new ViewBlock();
    }
}
