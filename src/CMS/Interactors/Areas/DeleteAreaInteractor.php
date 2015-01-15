<?php

namespace CMS\Interactors\Areas;

use CMS\Events\DeleteAreaEvent;
use CMS\Interactors\Blocks\DeleteBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Repositories\AreaRepositoryInterface;

class DeleteAreaInteractor extends GetAreaInteractor
{
    private $getAreasInteractor;
    private $getBlocksInteractor;
    private $deleteBlockInteractor;

    public function __construct(AreaRepositoryInterface $repository, GetAreasInteractor $getAreasInteractor, GetBlocksInteractor $getBlocksInteractor, DeleteBlockInteractor $deleteBlockInteractor, $eventDispatcher = null)
    {
        $this->repository = $repository;
        $this->getAreasInteractor = $getAreasInteractor;
        $this->getBlocksInteractor = $getBlocksInteractor;
        $this->deleteBlockInteractor = $deleteBlockInteractor;

        parent::__construct($repository, $eventDispatcher);
    }

    public function run($areaID)
    {
        if ($area = $this->getAreaByID($areaID)) {

            if ($area->getIsMaster()) {
                $this->deleteChildAreas($areaID);
            }

            $this->deleteBlocks($areaID);
            $this->repository->deleteArea($areaID);

            $this->fire(new DeleteAreaEvent(), $area);
        }
    }

    private function deleteBlocks($areaID)
    {
        $blocks = $this->getBlocksInteractor->getAllByAreaID($areaID);

        if (is_array($blocks) && sizeof($blocks) > 0) {
            foreach ($blocks as $block) {
                $this->deleteBlockInteractor->run($block->getID());
            }
        }
    }

    private function deleteChildAreas($areaID)
    {
        $childAreas = $this->getAreasInteractor->getChildAreas($areaID);

        if (is_array($childAreas) && sizeof($childAreas) > 0) {
            foreach ($childAreas as $childArea) {
                $this->run($childArea->getID());
            }
        }
    }
}
