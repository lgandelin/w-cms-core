<?php

namespace CMS\Interactors\Blocks;

use CMS\Repositories\BlockRepositoryInterface;
use CMS\Structures\BlockStructure;

class GetBlocksInteractor
{
    public function __construct(BlockRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllByAreaID($areaID, $structure = false)
    {
        $blocks = $this->repository->findByAreaID($areaID);

        return ($structure) ? $this->getBlockStructures($blocks) : $blocks;
    }

    public function getGlobalBlocks($structure = false)
    {
        $blocks = $this->repository->findGlobalBlocks();

        return ($structure) ? $this->getBlockStructures($blocks) : $blocks;
    }

    public function getChildBlocks($masterblockID, $structure = false)
    {
        $blocks = $this->repository->findChildBlocks($masterblockID);

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
