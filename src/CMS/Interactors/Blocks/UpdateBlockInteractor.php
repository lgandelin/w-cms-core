<?php

namespace CMS\Interactors\Blocks;

use CMS\Repositories\BlockRepositoryInterface;
use CMS\Structures\BlockStructure;

class UpdateBlockInteractor {

    private $repository;

    public function __construct(BlockRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run($blockID, BlockStructure $blockStructure)
    {
        if ($block = $this->getByID($blockID)) {
            if ($blockStructure->name !== null && $blockStructure->name != $block->getName()) $block->setName($blockStructure->name);
            if ($blockStructure->width !== null && $blockStructure->width != $block->getWidth()) $block->setWidth($blockStructure->width);
            if ($blockStructure->height !== null && $blockStructure->height != $block->getHeight()) $block->setHeight($blockStructure->height);
            if ($blockStructure->type !== null && $blockStructure->type != $block->getType()) $block->setType($blockStructure->type);
            if ($blockStructure->class !== null && $blockStructure->class != $block->getClass()) $block->setClass($blockStructure->class);
            if ($blockStructure->order !== null && $blockStructure->order != $block->getOrder()) $block->setOrder($blockStructure->order);
            if ($blockStructure->html !== null && $blockStructure->html != $block->getHTML()) $block->setHTML($blockStructure->html);
            if ($blockStructure->area_id !== null && $blockStructure->area_id != $block->getAreaId()) $block->setAreaID($blockStructure->area_id);
        }

        $this->repository->updateBlock($block);
    }

    public function getByID($blockID)
    {
        if (!$block = $this->repository->findByID($blockID))
            throw new \Exception('The block was not found');

        return $block;
    }
} 