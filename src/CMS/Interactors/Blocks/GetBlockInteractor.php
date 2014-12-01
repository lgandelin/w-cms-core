<?php

namespace CMS\Interactors\Blocks;

use CMS\Repositories\BlockRepositoryInterface;
use CMS\Structures\BlockStructure;

class GetBlockInteractor
{
    protected $repository;

    public function __construct(BlockRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getBlockByID($blockID, $structure = false)
    {
        if (!$block = $this->repository->findByID($blockID)) {
            throw new \Exception('The block was not found');
        }

        return ($structure) ? BlockStructure::toStructure($block) : $block;
    }
}
