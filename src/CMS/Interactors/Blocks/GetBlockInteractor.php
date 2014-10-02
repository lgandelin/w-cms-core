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

    public function getByID($blockID)
    {
        if (!$block = $this->repository->findByID($blockID))
            throw new \Exception('The block was not found');

        $blockStructure = new BlockStructure();
        $blockStructure->ID = $block->getID();
        $blockStructure->name = $block->getName();
        $blockStructure->width = $block->getWidth();
        $blockStructure->height = $block->getHeight();
        $blockStructure->class = $block->getClass();
        $blockStructure->order = $block->getOrder();
        $blockStructure->type = $block->getType();

        return $blockStructure;
    }

}