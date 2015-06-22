<?php

namespace CMS\Entities\Blocks;

use CMS\Entities\Block;

class GlobalBlock extends Block
{
    private $blockReferenceID;

    public function setBlockReferenceID($blockReferenceID)
    {
        $this->blockReferenceID = $blockReferenceID;
    }

    public function getBlockReferenceID()
    {
        return $this->blockReferenceID;
    }
}
