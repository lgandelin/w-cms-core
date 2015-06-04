<?php

namespace CMS\Interactors\Blocks;

use CMS\Context;
use CMS\Structures\BlockStructure;

class GetBlockInteractor
{
    public function getBlockByID($blockID, $structure = false)
    {
        if (!$block = Context::$blockRepository->findByID($blockID)) {
            throw new \Exception('The block was not found');
        }

        return ($structure) ? BlockStructure::toStructure($block) : $block;
    }
}
