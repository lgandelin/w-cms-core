<?php

namespace CMS\Interactors\Blocks;

use CMS\Repositories\BlockRepositoryInterface;

class DeleteBlockInteractor extends GetBlockInteractor
{
    public function __construct(BlockRepositoryInterface $repository, GetBlocksInteractor $getBlocksInteractor)
    {
        $this->repository = $repository;
        $this->getBlocksInteractor = $getBlocksInteractor;
    }

    public function run($blockID)
    {
        if ($block = $this->getBlockByID($blockID)) {

            if ($block->getIsMaster())
                $this->deleteChildBlocks($blockID);

            $this->repository->deleteBlock($blockID);
        }
    }

    private function deleteChildBlocks($blockID)
    {
        $childBlocks = $this->getBlocksInteractor->getChildBlocks($blockID);

        if (is_array($childBlocks) && sizeof($childBlocks) > 0) {
            foreach ($childBlocks as $childBlock) {
                $this->repository->deleteBlock($childBlock->getID());
            }
        }
    }
}
