<?php

namespace CMS\Interactors\Blocks;

use CMS\Context;

class GetBlocksInteractor
{
    public function getAllByAreaID($areaID, $structure = false)
    {
        $blocks = Context::get('block')->findByAreaID($areaID);

        return ($structure) ? $this->getDataStructures($blocks) : $blocks;
    }

    public function getGlobalBlocks($structure = false)
    {
        $blocks = Context::get('block')->findGlobalBlocks();

        return ($structure) ? $this->getDataStructures($blocks) : $blocks;
    }

    public function getChildBlocks($masterblockID, $structure = false)
    {
        $blocks = Context::get('block')->findChildBlocks($masterblockID);

        return ($structure) ? $this->getDataStructures($blocks) : $blocks;
    }

    private function getDataStructures($blocks)
    {
        $blockStructures = [];
        if (is_array($blocks) && sizeof($blocks) > 0) {
            foreach ($blocks as $block) {
                if ($block) {
                    $blockStructure = $block->toStructure();
                    $blockStructure->content = $block->getContentData();
                    if (Context::get('block_type')) {
                        $blockStructure->type = Context::get('block_type')->getBlockTypeByCode($block->getType());
                    }
                    $blockStructures[]= $blockStructure;
                }
            }
        }

        return $blockStructures;
    }
}
