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

    public function getAll($areaID, $structure = false)
    {
        $blocks = $this->repository->findByAreaID($areaID);

        if ($structure) {
            $blockStructures = [];
            if (is_array($blocks) && sizeof($blocks) > 0)
                foreach ($blocks as $block)
                    $blockStructures[]= BlockStructure::toStructure($block);

            return $blockStructures;
        } else
            return $blocks;
    }
}