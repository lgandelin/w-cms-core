<?php

namespace Webaccess\WCMSCore\Interactors\Blocks;

use Webaccess\WCMSCore\Context;

class GetBlockInteractor
{
    public function getBlockByID($blockID, $structure = false)
    {
        if (!$block = Context::get('block')->findByID($blockID)) {
            throw new \Exception('The block was not found');
        }

        return ($structure) ? $block->toStructure() : $block;
    }
}
