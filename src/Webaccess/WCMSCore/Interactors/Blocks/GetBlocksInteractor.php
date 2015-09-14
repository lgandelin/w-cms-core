<?php

namespace Webaccess\WCMSCore\Interactors\Blocks;

use Webaccess\WCMSCore\Context;

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
        $blockStructures = [];
        if (is_array($blocks) && sizeof($blocks) > 0) {
            foreach ($blocks as $block) {
                if ($block) {
                    $blockStructure = $block->toStructure();
                    $blockStructure->content = $block->getContentData();
                    if (Context::get('block_type_repository')) {
                        $blockStructure->type = Context::get('block_type_repository')->getBlockTypeByCode($block->getType(), true);
                    }
                    $blockStructures[]= $blockStructure;
                }
            }
        }

        return $blockStructures;
    }
}
