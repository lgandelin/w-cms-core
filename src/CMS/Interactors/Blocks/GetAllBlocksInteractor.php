<?php

namespace CMS\Interactors\Blocks;

use CMS\Interactors\Areas\GetAreaInteractor;
use CMS\Repositories\AreaRepositoryInterface;
use CMS\Repositories\BlockRepositoryInterface;

class GetAllBlocksInteractor {

    public function __construct(BlockRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll($areaID)
    {
        return $this->repository->findByAreaID($areaID);
    }

}