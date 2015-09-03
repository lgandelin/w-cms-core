<?php

namespace Webaccess\WCMSCore\Interactors\Blocks;

use Webaccess\WCMSCore\Context;

class UpdateBlockTypeInteractor extends GetBlockInteractor
{
    public function run($blockID, $type)
    {
        if ($block = $this->getBlockByID($blockID)) {
            if ($type !== null && $type != $block->getType()) {
                $block->setType($type);
                Context::get('block')->updateBlockType($block);
            }
        }
    }
} 