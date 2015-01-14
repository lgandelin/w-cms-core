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
        if ($area = $this->getAreaByID($areaID)) {

            if ($area->getIsMaster())
                $this->deleteChildAreas($areaID);
            
            $this->deleteBlocks($areaID);
            $this->repository->deleteArea($areaID);
        }
    }

    private function deleteBlocks($areaID)
    {
        $blocks = $this->getBlocksInteractor->getAllByAreaID    ($areaID);

        foreach ($blocks as $block) {
            $this->deleteBlockInteractor->run($block->getID());
        }
    }

    private function deleteChildAreas($areaID)
    {
        $childAreas = $this->repository->findChildAreas($areaID);

        if (is_array($childAreas) && sizeof($childAreas) > 0) {
            foreach ($childAreas as $childArea) {
                $this->deleteBlocks($childArea->getID());
                $this->repository->deleteArea($childArea->getID());
            }
        }
    }
}
