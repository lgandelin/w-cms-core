<?php

namespace Webaccess\WCMSCore\Entities\Blocks;

use Webaccess\WCMSCore\Entities\Block;

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
