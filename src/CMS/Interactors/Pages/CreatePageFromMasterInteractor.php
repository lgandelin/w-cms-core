<?php

namespace CMS\Interactors\Pages;

use CMS\Entities\Page;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Areas\UpdateAreaInteractor;
use CMS\Interactors\Areas\DuplicateAreaInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Blocks\DuplicateBlockInteractor;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Repositories\PageRepositoryInterface;
use CMS\Structures\AreaStructure;
use CMS\Structures\BlockStructure;
use CMS\Structures\PageStructure;
use CMS\Structures\Blocks\ArticleBlockStructure;

class CreatePageFromMasterInteractor
{
    protected $repository;
    private $createPageInteractor;
    private $getAreasInteractor;
    private $updateAreaInteractor;
    private $duplicateAreaInteractor;
    private $getBlocksInteractor;
    private $updateBlockInteractor;
    private $duplicateBlockInteractor;

    public function __construct(PageRepositoryInterface $repository, CreatePageInteractor $createPageInteractor, GetAreasInteractor $getAreasInteractor, UpdateAreaInteractor $updateAreaInteractor, DuplicateAreaInteractor $duplicateAreaInteractor, GetBlocksInteractor $getBlocksInteractor, UpdateBlockInteractor $updateBlockInteractor, DuplicateBlockInteractor $duplicateBlockInteractor)
    {
        $this->repository = $repository;
        $this->createPageInteractor = $createPageInteractor;
        $this->getAreasInteractor = $getAreasInteractor;
        $this->updateAreaInteractor = $updateAreaInteractor;
        $this->duplicateAreaInteractor = $duplicateAreaInteractor;
        $this->getBlocksInteractor = $getBlocksInteractor;
        $this->updateBlockInteractor = $updateBlockInteractor;
        $this->duplicateBlockInteractor = $duplicateBlockInteractor;
    }

    public function run(PageStructure $pageStructure, $customBlock = null)
    {
        $pageID = $this->createPageInteractor->run($pageStructure);

        //If the page is a child page, create areas and blocks according to the master page
        if ($pageStructure->master_page_id) {
            $areas = $this->getAreasInteractor->getAll($pageStructure->master_page_id);

            foreach ($areas as $area) {
                $newAreaID = $this->duplicateAreaInteractor->run($area, $pageID);
                $areaStructure = new AreaStructure([
                    'master_area_id' => $area->getID()
                ]);
                $this->updateAreaInteractor->run($newAreaID, $areaStructure);

                $blocks = $this->getBlocksInteractor->getAllByAreaID($area->getID());

                foreach ($blocks as $block) {
                    if ($block->getIsGhost()) {
                        if ($customBlock) {
                            $newBlockID = $this->duplicateBlockInteractor->run($block, $newAreaID);
                            $customBlock->is_ghost = 0;
                            $this->updateBlockInteractor->run($newBlockID, $customBlock);
                        }
                    } else {
                        $newBlockID = $this->duplicateBlockInteractor->run($block, $newAreaID);

                        $blockStructure = new BlockStructure([
                            'master_block_id' => $block->getID()
                        ]);
                        $this->updateBlockInteractor->run($newBlockID, $blockStructure);
                    }
                }
            }
        }

        return $pageID;
    }
}
