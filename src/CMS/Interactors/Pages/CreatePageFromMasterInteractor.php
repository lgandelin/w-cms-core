<?php

namespace CMS\Interactors\Pages;

use CMS\Interactors\Areas\DuplicateAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Areas\UpdateAreaInteractor;
use CMS\Interactors\Blocks\DuplicateBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Structures\AreaStructure;
use CMS\Structures\BlockStructure;
use CMS\Structures\PageStructure;

class CreatePageFromMasterInteractor
{
    public function run(PageStructure $pageStructure, $customBlock = null)
    {
        $pageID = (new CreatePageInteractor())->run($pageStructure);

        //If the page is a child page, create areas and blocks according to the master page
        if ($pageStructure->master_page_id) {
            $areas = (new GetAreasInteractor())->getAll($pageStructure->master_page_id);

            foreach ($areas as $area) {
                $newAreaID = (new DuplicateAreaInteractor())->run(AreaStructure::toStructure($area), $pageID);
                $areaStructure = new AreaStructure([
                    'master_area_id' => $area->getID()
                ]);
                (new UpdateAreaInteractor())->run($newAreaID, $areaStructure);

                $blocks = (new GetBlocksInteractor())->getAllByAreaID($area->getID());

                foreach ($blocks as $block) {
                    $newBlockID = (new DuplicateBlockInteractor())->run(BlockStructure::toStructure($block), $newAreaID);

                    if ($block->getIsGhost()) {
                        if ($customBlock) {
                            $customBlock->is_ghost = 0;
                            $customBlock->master_block_id = $block->getID();
                            (new UpdateBlockInteractor())->run($newBlockID, $customBlock);
                        }
                    } else {
                        $blockStructure = $block->getStructure();
                        $blockStructure->master_block_id = $block->getID();
                        (new UpdateBlockInteractor())->run($newBlockID, $blockStructure);
                    }
                }
            }
        }

        return $pageID;
    }
}
