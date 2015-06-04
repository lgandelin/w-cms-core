<?php

namespace CMS\Interactors\Blocks;

use CMS\Context;
use CMS\Structures\BlockStructure;

class GetBlocksInteractor
{
    public function getAllByAreaID($areaID, $structure = false)
    {
        $blocks = Context::$blockRepository->findByAreaID($areaID);

        return ($structure) ? $this->getBlockStructures($blocks) : $blocks;
    }

    public function getGlobalBlocks($structure = false)
    {
        $blocks = Context::$blockRepository->findGlobalBlocks();

        return ($structure) ? $this->getBlockStructures($blocks) : $blocks;
    }

    public function getChildBlocks($masterblockID, $structure = false)
    {
        $blocks = Context::$blockRepository->findChildBlocks($masterblockID);

        return ($structure) ? $this->getBlockStructures($blocks) : $blocks;
    }

    private function getBlockStructures($blocks)
    {
        $blockStructures = [];
        if (is_array($blocks) && sizeof($blocks) > 0) {
            foreach ($blocks as $block) {
                $blockStructures[]= BlockStructure::toStructure($block);
            }
        }

        return $blockStructures;
    }
}
