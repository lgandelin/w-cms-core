<?php

namespace Webaccess\WCMSCore\Interactors\Blocks;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Block;

class DuplicateBlockInteractor
{
    public function run(Block $blockToDuplicate, $newAreaID, $newPageVersion = 0)
    {
        $block = clone $blockToDuplicate;
        $block->setID(null);
        $block->setAreaID($newAreaID);
        $block->setVersionNumber($newPageVersion);

        $blockID = Context::get('block_repository')->duplicateBlock($block);

        return $blockID;
    }
}
