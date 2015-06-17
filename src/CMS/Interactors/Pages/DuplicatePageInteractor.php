<?php

namespace CMS\Interactors\Pages;

use CMS\Interactors\Areas\DuplicateAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Blocks\DuplicateBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Structures\BlockStructure;

class DuplicatePageInteractor extends GetPageInteractor
{
    public function run($pageID)
    {
        if ($page = $this->getPageByID($pageID)) {
            $newPageID = $this->duplicatePage($page);
            $this->duplicateAreas($pageID, $newPageID);
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

        return (new CreatePageInteractor())->run($pageDuplicated->toStructure());
    }

    private function duplicateAreas($pageID, $newPageID)
    {
        $areas = (new GetAreasInteractor())->getAll($pageID);

        if (is_array($areas) && sizeof($areas) > 0) {
            foreach ($areas as $area) {
                $newAreaID = (new DuplicateAreaInteractor())->run($area->toStructure(), $newPageID);
                $this->duplicateBLocks($area->getID(), $newAreaID);
            }
        }
    }

    private function duplicateBLocks($areaID, $newAreaID)
    {
        $blocks = (new GetBlocksInteractor())->getAllByAreaID($areaID);

        if (is_array($blocks) && sizeof($blocks) > 0) {
            foreach ($blocks as $block) {
                (new DuplicateBlockInteractor())->run(BlockStructure::toStructure($block), $newAreaID);
            }
        }
    }
}
