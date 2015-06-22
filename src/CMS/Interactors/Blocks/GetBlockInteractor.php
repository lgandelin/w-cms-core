<?php

namespace CMS\Interactors\Blocks;

use CMS\Context;

class GetBlockInteractor
{
    public function getBlockByID($blockID, $structure = false)
    {
        if (!$block = Context::getRepository('block')->findByID($blockID)) {
            throw new \Exception('The block was not found');
        }

        return ($structure) ? $block->toStructure() : $block;
    }
}
