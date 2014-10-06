<?php

namespace CMS\Interactors\Blocks;

class DeleteBlockInteractor extends GetBlockInteractor
{
    public function run($blockID)
    {
        if ($this->getBlockByID($blockID))
            $this->repository->deleteBlock($blockID);
    }
} 