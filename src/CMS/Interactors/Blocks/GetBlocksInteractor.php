<?php

namespace CMS\Interactors\Blocks;

use CMS\Context;
use CMS\Structures\BlockStructure;

class GetBlocksInteractor
{
    public function getAllByAreaID($areaID, $structure = false)
    {
        $blocks = Context::getRepository('block')->findByAreaID($areaID);

        return ($structure) ? $this->getBlockStructures($blocks) : $blocks;
    }

    public function getGlobalBlocks($structure = false)
    {
        $blocks = Context::getRepository('block')->findGlobalBlocks();

        return ($structure) ? $this->getBlockStructures($blocks) : $blocks;
    }

    public function getChildBlocks($masterblockID, $structure = false)
    {
        $blocks = Context::getRepository('block')->findChildBlocks($masterblockID);

        return ($structure) ? $this->getBlockStructures($blocks) : $blocks;
    }

    private function getBlockStructures($blocks)
    {
        $blockStructures = [];
        if (is_array($blocks) && sizeof($blocks) > 0) {
            foreach ($blocks as $block) {
                $blockStructure = BlockStructure::toStructure($block);
                $blockStructure->content = $block->getContentData();
                $blockStructures[]= $blockStructure;
            }
        }

        return $blockStructures;
    }
}
