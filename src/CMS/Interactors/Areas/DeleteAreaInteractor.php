<?php

namespace CMS\Interactors\Areas;

use CMS\Interactors\Blocks\DeleteBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Repositories\AreaRepositoryInterface;

class DeleteAreaInteractor extends GetAreaInteractor
{
    private $getBlocksInteractor;
    private $deleteBlockInteractor;

    public function __construct(AreaRepositoryInterface $repository, GetBlocksInteractor $getBlocksInteractor, DeleteBlockInteractor $deleteBlockInteractor)
    {
        $this->repository = $repository;
        $this->getBlocksInteractor = $getBlocksInteractor;
        $this->deleteBlockInteractor = $deleteBlockInteractor;
    }

    public function run($areaID)
    {
        if ($this->getAreaByID($areaID)) {
            $this->deleteBlocks($areaID);
            $this->repository->deleteArea($areaID);
        }
    }

    private function deleteBlocks($areaID)
    {
        $blocks = $this->getBlocksInteractor->getAll($areaID);

        foreach ($blocks as $block)
            $this->deleteBlockInteractor->run($block->getID());
    }
}