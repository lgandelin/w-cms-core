<?php

namespace Webaccess\WCMSCore\Interactors\Pages;

use Webaccess\WCMSCore\Interactors\Areas\DuplicateAreaInteractor;
use Webaccess\WCMSCore\Interactors\Areas\GetAreasInteractor;
use Webaccess\WCMSCore\Interactors\Areas\UpdateAreaInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\DuplicateBlockInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlocksInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\UpdateBlockInteractor;
use Webaccess\WCMSCore\DataStructure;

class CreatePageFromMasterInteractor
{
    public function run(DataStructure $pageStructure, $customBlock = null)
    {
        $pageID = (new CreatePageInteractor())->run($pageStructure);

        //If the page is a child page, create areas and blocks according to the master page
        if (isset($pageStructure->masterPageID)){
            $areas = (new GetAreasInteractor())->getAll($pageStructure->masterPageID);

            foreach ($areas as $area) {
                $newAreaID = (new DuplicateAreaInteractor())->run($area->toStructure(), $pageID);
                $areaStructure = new DataStructure([
                    'master_area_id' => $area->getID()
                ]);
                (new UpdateAreaInteractor())->run($newAreaID, $areaStructure);

                $blocks = (new GetBlocksInteractor())->getAllByAreaID($area->getID());

                foreach ($blocks as $block) {
                    $newBlockID = (new DuplicateBlockInteractor())->run($block->toStructure(), $newAreaID);

                    if ($block->getIsGhost()) {
                        if ($customBlock) {
                            $customBlock->is_ghost = 0;
                            $customBlock->master_block_id = $block->getID();
                            (new UpdateBlockInteractor())->run($newBlockID, $customBlock);
                        }
                    } else {
                        $blockStructure = $block->toStructure();
                        $blockStructure->master_block_id = $block->getID();
                        (new UpdateBlockInteractor())->run($newBlockID, $blockStructure);
                    }
                }
            }
        }

        return $pageID;
    }
}
