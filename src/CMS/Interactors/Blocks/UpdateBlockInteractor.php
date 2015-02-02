<?php

namespace CMS\Interactors\Blocks;

use CMS\Repositories\BlockRepositoryInterface;
use CMS\Structures\BlockStructure;

class UpdateBlockInteractor extends GetBlockInteractor
{
    protected $repository;
    private $getBlocksInteractor;

    public function __construct(BlockRepositoryInterface $repository, GetBlocksInteractor $getBlocksInteractor)
    {
        $this->repository = $repository;
        $this->getBlocksInteractor = $getBlocksInteractor;
    }

    public function run($blockID, BlockStructure $blockStructure)
    {
        if ($block = $this->getBlockByID($blockID)) {
            if ($blockStructure->type !== null && $blockStructure->type != $block->getType()) {
                $block->setType($blockStructure->type);
            }
            $this->repository->updateBlockType($block);
        }

        if ($block = $this->getBlockByID($blockID)) {

            if ($blockStructure->name !== null && $blockStructure->name != $block->getName()) {
                $block->setName($blockStructure->name);
            }

            if ($blockStructure->width !== null && $blockStructure->width != $block->getWidth()) {
                $block->setWidth($blockStructure->width);
            }

            if ($blockStructure->height !== null && $blockStructure->height != $block->getHeight()) {
                $block->setHeight($blockStructure->height);
            }

            if ($blockStructure->class !== null && $blockStructure->class != $block->getClass()) {
                $block->setClass($blockStructure->class);
            }

            if ($blockStructure->order !== null && $blockStructure->order != $block->getOrder()) {
                $block->setOrder($blockStructure->order);
            }

            if (isset($blockStructure->area_id) && $blockStructure->area_id !== null && $blockStructure->area_id != $block->getAreaId()) {
                $block->setAreaID($blockStructure->area_id);
            }

            if ($blockStructure->display !== null && $blockStructure->display != $block->getDisplay()) {
                $block->setDisplay($blockStructure->display);
            }

            if ($blockStructure->is_global !== null && $blockStructure->is_global != $block->getIsGlobal()) {
                $block->setIsGlobal($blockStructure->is_global);
            }

            if ($blockStructure->master_block_id !== null && $blockStructure->master_block_id != $block->getMasterBlockID()) {
                $block->setMasterBlockID($blockStructure->master_block_id);
            }

            if ($blockStructure->is_ghost !== null && $blockStructure->is_ghost != $block->getIsGhost()) {
                $block->setIsGhost($blockStructure->is_ghost);
            }

            if (isset($blockStructure->is_master) && $blockStructure->is_master !== null && $blockStructure->is_master != $block->getIsMaster()) {
                $block->setIsMaster($blockStructure->is_master);
            }

            if (!$block->getIsGhost()) {
                $block->updateContent($blockStructure);
            }

            if ($block->getIsMaster()) {
                unset($blockStructure->area_id);
                unset($blockStructure->is_master);
                $this->updateChildBlocks($blockStructure, $block->getID());
            }
        }

        $this->repository->updateBlock($block);
    }

    private function updateChildBlocks(BlockStructure $blockStructure, $blockID)
    {
        $childBlocks = $this->getBlocksInteractor->getChildBlocks($blockID);

        if (is_array($childBlocks) && sizeof($childBlocks) > 0) {
            foreach ($childBlocks as $child) {
                $this->run($child->getID(), $blockStructure);
            }
        }
    }
}
