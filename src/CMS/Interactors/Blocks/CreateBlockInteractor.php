<?php

namespace CMS\Interactors\Blocks;

use CMS\Entities\Block;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Repositories\BlockRepositoryInterface;
use CMS\Structures\BlockStructure;

class CreateBlockInteractor
{
    private $repository;
    private $getAreasInteractor;

    public function __construct(BlockRepositoryInterface $repository, GetAreasInteractor $getAreasInteractor)
    {
        $this->repository = $repository;
        $this->getAreasInteractor = $getAreasInteractor;
    }

    public function run(BlockStructure $blockStructure)
    {
        $block = $this->createBlockFromStructure($blockStructure);

        $block->valid();

        $blockID = $this->repository->createBlock($block);

        if ($block->getIsMaster()) {
            $this->createBlockInChildAreas($blockStructure, $blockID, $block->getAreaID());
        }
        
        return $blockID;
    }

    private function createBlockFromStructure(BlockStructure $blockStructure)
    {
        $block = new Block();

        if ($blockStructure->name !== null) {
            $block->setName($blockStructure->name);
        }

        if ($blockStructure->width !== null) {
            $block->setWidth($blockStructure->width);
        }

        if ($blockStructure->height !== null) {
            $block->setHeight($blockStructure->height);
        }

        if ($blockStructure->type !== null) {
            $block->setType($blockStructure->type);
        }

        if ($blockStructure->class !== null) {
            $block->setClass($blockStructure->class);
        }

        if ($blockStructure->order !== null) {
            $block->setOrder($blockStructure->order);
        }

        if ($blockStructure->area_id !== null) {
            $block->setAreaID($blockStructure->area_id);
        }

        if ($blockStructure->display !== null) {
            $block->setDisplay($blockStructure->display);
        }

        if ($blockStructure->is_ghost !== null) {
            $block->setIsGhost($blockStructure->is_ghost);
        }

        if ($blockStructure->is_master !== null) {
            $block->setIsMaster($blockStructure->is_master);
        }

        if ($blockStructure->master_block_id !== null) {
            $block->setMasterBlockID($blockStructure->master_block_id);
        }

        return $block;
    }

    private function createBlockInChildAreas($blockStructure, $blockID, $areaID)
    {
        $childAreas = $this->getAreasInteractor->getChildAreas($areaID);

        if (is_array($childAreas) && sizeof($childAreas) > 0) {
            foreach ($childAreas as $childArea) {
                $blockStructure = new BlockStructure([
                    'name' => $blockStructure->name,
                    'area_id' => $childArea->getID(),
                    'master_block_id' => $blockID,
                    'width' => $blockStructure->width,
                    'height' => $blockStructure->height,
                    'order' => $blockStructure->order,
                    'display' => $blockStructure->display,
                    'type' => $blockStructure->type,
                ]);
                $this->run($blockStructure);
            }
        }
    }
}
