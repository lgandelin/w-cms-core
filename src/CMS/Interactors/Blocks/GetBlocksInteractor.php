<?php

namespace CMS\Interactors\Blocks;

use CMS\Interactors\Areas\GetAreaInteractor;
use CMS\Repositories\AreaRepositoryInterface;
use CMS\Repositories\BlockRepositoryInterface;
use CMS\Structures\BlockStructure;

class GetBlocksInteractor extends GetAreaInteractor
{
    private $areaRepository;

    public function __construct(BlockRepositoryInterface $repository, AreaRepositoryInterface $areaRepository)
    {
        $this->repository = $repository;
        $this->areaRepository = $areaRepository;
    }

    public function getAll($areaID, $structure = false)
    {
        if ($this->getAreaByID($areaID)) {
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
}