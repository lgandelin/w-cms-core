<?php

namespace CMS\Interactors\Blocks;

class DeleteBlockInteractor extends GetBlockInteractor
{
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
        $childBlocks = $this->repository->findChildBlocks($blockID);

        if (is_array($childBlocks) && sizeof($childBlocks) > 0) {
            foreach ($childBlocks as $childBlock) {
                $this->repository->deleteBlock($childBlock->getID());
            }
        }
    }
}
