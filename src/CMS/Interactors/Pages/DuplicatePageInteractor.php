<?php

namespace CMS\Interactors\Pages;

use CMS\Interactors\Areas\DuplicateAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Blocks\DuplicateBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Structures\AreaStructure;
use CMS\Structures\BlockStructure;
use CMS\Structures\PageStructure;

class DuplicatePageInteractor extends GetPageInteractor
{
    public function run($pageID)
    {
        if ($page = $this->getPageByID($pageID)) {
            $newPageID = $this->duplicatePage($page);

            $areas = (new GetAreasInteractor())->getAll($pageID);

            foreach ($areas as $area) {
                $newAreaID = (new DuplicateAreaInteractor())->run(AreaStructure::toStructure($area), $newPageID);
                $blocks = (new GetBlocksInteractor())->getAllByAreaID($area->getID());

                foreach ($blocks as $block) {
                    (new DuplicateBlockInteractor())->run(BlockStructure::toStructure($block), $newAreaID);
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
        $pageDuplicated->setLangID($page->getLangID());
        $pageDuplicated->setIdentifier($page->getIdentifier() . '-copy');

        return (new CreatePageInteractor())->run(PageStructure::toStructure($pageDuplicated));
    }
}
