<?php

namespace CMS\Interactors\Blocks;

use CMS\Entities\Block;
use CMS\Interactors\Areas\GetAreaInteractor;
use CMS\Repositories\BlockRepositoryInterface;
use CMS\Structures\BlockStructure;

class CreateBlockInteractor extends GetAreaInteractor
{
    private $repository;

    public function __construct(BlockRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(BlockStructure $blockStructure)
    {
        if ($this->getAreaByID($blockStructure->area_id)) {
            $block = $this->createBlockFromStructure($blockStructure);

            if ($block->valid())
                return $this->repository->createBlock($block);
        }
    }

    private function createBlockFromStructure(BlockStructure $blockStructure)
    {
        $block = new Block();
        if ($blockStructure->name !== null) $block->setName($blockStructure->name);
        if ($blockStructure->width !== null) $block->setWidth($blockStructure->width);
        if ($blockStructure->height !== null) $block->setHeight($blockStructure->height);
        if ($blockStructure->type !== null) $block->setType($blockStructure->type);
        if ($blockStructure->class !== null) $block->setClass($blockStructure->class);
        if ($blockStructure->order !== null) $block->setOrder($blockStructure->order);
        if ($blockStructure->area_id !== null) $block->setAreaID($blockStructure->area_id);
        if ($blockStructure->display !== null) $block->setDisplay($blockStructure->display);

        return $block;
    }
}