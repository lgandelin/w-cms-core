<?php

namespace Webaccess\WCMSCore\Interactors\Blocks;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Block;

class DuplicateBlockInteractor
{
    public function run(Block $block, $newAreaID)
    {
        $block->setID(null);
        $block->setAreaID($newAreaID);

        $blockID = Context::get('block_repository')->duplicateBlock($block);

        return $blockID;
    }
}
