<?php

namespace CMS\Interactors\Pages;

use CMS\Interactors\Areas\DeleteAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Blocks\DeleteBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Repositories\PageRepositoryInterface;

class DeletePageInteractor extends GetPageInteractor
{
    public function __construct(PageRepositoryInterface $repository, GetAreasInteractor $getAreasInteractor, GetBlocksInteractor $getBlocksInteractor, DeleteAreaInteractor $deleteAreaInteractor, DeleteBlockInteractor $deleteBlockInteractor)
    {
        parent::__construct($repository);

        $this->getAreasInteractor = $getAreasInteractor;
        $this->getBlocksInteractor = $getBlocksInteractor;
        $this->deleteAreaInteractor = $deleteAreaInteractor;
        $this->deleteBlockInteractor = $deleteBlockInteractor;
    }

    public function run($pageID)
    {
        if ($this->getPageByID($pageID)) {
            $areas = $this->getAreasInteractor->getAll($pageID, true);

            foreach ($areas as $area) {
                $blocks = $this->getBlocksInteractor->getAll($area->ID, true);

                foreach ($blocks as $block)
                    $this->deleteBlockInteractor->run($block->ID);

                $this->deleteAreaInteractor->run($area->ID);
            }

            $this->repository->deletePage($pageID);
        }
    }
}