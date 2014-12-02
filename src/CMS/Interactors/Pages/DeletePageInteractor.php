<?php

namespace CMS\Interactors\Pages;

use CMS\Interactors\Areas\DeleteAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Repositories\PageRepositoryInterface;

class DeletePageInteractor extends GetPageInteractor
{
    public function __construct(PageRepositoryInterface $repository, GetAreasInteractor $getAreasInteractor, DeleteAreaInteractor $deleteAreaInteractor)
    {
        parent::__construct($repository);

        $this->getAreasInteractor = $getAreasInteractor;
        $this->deleteAreaInteractor = $deleteAreaInteractor;
    }

    public function run($pageID)
    {
        if ($this->getPageByID($pageID)) {
            $areas = $this->getAreasInteractor->getAll($pageID);

            foreach ($areas as $area) {
                $this->deleteAreaInteractor->run($area->getID());
            }

            $this->repository->deletePage($pageID);
        }
    }
}
