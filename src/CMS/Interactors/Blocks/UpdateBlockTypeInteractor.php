<?php

namespace CMS\Interactors\Blocks;

use CMS\Context;

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