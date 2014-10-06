<?php

namespace CMS\Interactors\Areas;

use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Repositories\AreaRepositoryInterface;
use CMS\Repositories\PageRepositoryInterface;
use CMS\Structures\AreaStructure;

class GetAreasInteractor extends GetPageInteractor
{
    private $pageRepository;

    public function __construct(AreaRepositoryInterface $repository, PageRepositoryInterface $pageRepository)
    {
        $this->repository = $repository;
        $this->pageRepository = $pageRepository;
    }

    public function getAll($pageID, $structure = false)
    {
        if ($this->getPageByID($pageID)) {
            $areas = $this->repository->findByPageID($pageID);

            if ($structure) {
                $areaStructures = [];
                if (is_array($areas) && sizeof($areas) > 0)
                    foreach ($areas as $area)
                        $areaStructures[]= AreaStructure::toStructure($area);

                return $areaStructures;
            } else
                return $areas;
        }
    }
}