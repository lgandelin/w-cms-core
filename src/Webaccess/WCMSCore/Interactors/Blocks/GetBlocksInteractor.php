<?php

namespace Webaccess\WCMSCore\Interactors\Blocks;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\BlockTypes\GetBlockTypeInteractor;

class GetBlocksInteractor
{
    public function getAllByAreaID($areaID, $structure = false)
    {
        $blocks = Context::get('block_repository')->findByAreaID($areaID);

        return ($structure) ? $this->getDataStructures($blocks) : $blocks;
    }

    public function getGlobalBlocks($structure = false)
    {
        $blocks = Context::get('block_repository')->findGlobalBlocks();

        return ($structure) ? $this->getDataStructures($blocks) : $blocks;
    }

    public function getChildBlocks($masterblockID, $structure = false)
    {
        $blocks = Context::get('block_repository')->findChildBlocks($masterblockID);

        return ($structure) ? $this->getDataStructures($blocks) : $blocks;
    }

    private function getDataStructures($blocks)
    {
        return array_map(function($block) {
            $blockStructure = $block->toStructure();
            $blockStructure->type = (new GetBlockTypeInteractor())->getBlockTypeByCode($block->getType(), true);
            return $blockStructure;
        }, $blocks);
    }
}
