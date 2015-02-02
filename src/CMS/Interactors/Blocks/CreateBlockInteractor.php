<?php

namespace CMS\Interactors\Blocks;

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
        $block = $blockStructure->getBlock();
        $block->setInfos($blockStructure);
        $block->valid();

        $blockID = $this->repository->createBlock($block);

        if ($block->getIsMaster()) {
            $this->createBlockInChildAreas($blockStructure, $blockID, $block->getAreaID());
        }
        
        return $blockID;
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
