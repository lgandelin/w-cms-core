<?php

namespace CMS\Interactors\Blocks;

use CMS\Repositories\BlockRepositoryInterface;

class DeleteBlockInteractor {

    private $repository;

    public function __construct(BlockRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run($blockID)
    {
        if ($this->getByID($blockID))
            $this->repository->deleteBlock($blockID);
    }

    public function getByID($blockID)
    {
        if (!$block = $this->repository->findByID($blockID))
            throw new \Exception('The block was not found');

        return $block;
    }
} 