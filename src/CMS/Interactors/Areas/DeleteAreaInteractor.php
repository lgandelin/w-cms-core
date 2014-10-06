<?php

namespace CMS\Interactors\Areas;

use CMS\Repositories\AreaRepositoryInterface;
use CMS\Repositories\BlockRepositoryInterface;

class DeleteAreaInteractor extends GetAreaInteractor {

    private $repository;
    private $blockRepository;

    public function __construct(AreaRepositoryInterface $repository, BlockRepositoryInterface $blockRepository)
    {
        $this->repository = $repository;
        $this->blockRepository = $blockRepository;
    }

    public function run($areaID)
    {
        if ($this->getAreaByID($areaID)) {

            if ($this->areaHasBlocks($areaID))
                throw new \Exception('The area still has blocks inside');

            $this->repository->deleteArea($areaID);
        }

    }

    private function areaHasBlocks($areaID)
    {
        return sizeof($this->blockRepository->findByAreaID($areaID));
    }
} 