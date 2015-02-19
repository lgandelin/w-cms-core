<?php

namespace CMS\Interactors\Pages;

use CMS\Interactors\Areas\DuplicateAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Blocks\DuplicateBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Repositories\PageRepositoryInterface;
use CMS\Structures\AreaStructure;
use CMS\Structures\BlockStructure;
use CMS\Structures\PageStructure;

class DuplicatePageInteractor extends GetPageInteractor
{
    public function __construct(
        PageRepositoryInterface $repository,
        GetAreasInteractor $getAreasInteractor,
        GetBlocksInteractor $getBlocksInteractor,
        CreatePageInteractor $createPageInteractor,
        DuplicateAreaInteractor $duplicateAreaInteractor,
        DuplicateBlockInteractor $duplicateBlockInteractor
    ) {
        parent::__construct($repository);

        $this->getAreasInteractor = $getAreasInteractor;
        $this->getBlocksInteractor = $getBlocksInteractor;
        $this->createPageInteractor = $createPageInteractor;
        $this->duplicateAreaInteractor = $duplicateAreaInteractor;
        $this->duplicateBlockInteractor = $duplicateBlockInteractor;
    }

    public function run($pageID)
    {
        if ($page = $this->getPageByID($pageID)) {
            $newPageID = $this->duplicatePage($page);

            $areas = $this->getAreasInteractor->getAll($pageID);

            foreach ($areas as $area) {
                $newAreaID = $this->duplicateAreaInteractor->run(AreaStructure::toStructure($area), $newPageID);
                $blocks = $this->getBlocksInteractor->getAllByAreaID($area->getID());

                foreach ($blocks as $block) {
                    $this->duplicateBlockInteractor->run(BlockStructure::toStructure($block), $newAreaID);
                }
            }
        }
    }

    private function duplicatePage($page)
    {
        $pageDuplicated = clone $page;
        $pageDuplicated->setID(null);
        $pageDuplicated->setName($page->getName() . ' - COPY');
        $pageDuplicated->setURI($page->getURI() . '-copy');
        $pageDuplicated->setIdentifier($page->getIdentifier() . '-copy');

        return $this->createPageInteractor->run(PageStructure::toStructure($pageDuplicated));
    }
}
