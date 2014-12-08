<?php

namespace CMS\Interactors\Pages;

use CMS\Interactors\Areas\CreateAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Blocks\CreateBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Repositories\PageRepositoryInterface;
use CMS\Structures\Blocks\ArticleBlockStructure;
use CMS\Structures\Blocks\ArticleListBlockStructure;
use CMS\Structures\BlockStructure;
use CMS\Structures\Blocks\MenuBlockStructure;
use CMS\Structures\Blocks\HTMLBlockStructure;
use CMS\Structures\Blocks\ViewFileBlockStructure;
use CMS\Structures\AreaStructure;
use CMS\Structures\PageStructure;

class DuplicatePageInteractor extends GetPageInteractor
{
    public function __construct(PageRepositoryInterface $repository, GetAreasInteractor $getAreasInteractor, GetBlocksInteractor $getBlocksInteractor, CreatePageInteractor $createPageInteractor, CreateAreaInteractor $createAreaInteractor, CreateBlockInteractor $createBlockInteractor, UpdateBlockInteractor $updateBlockInteractor)
    {
        parent::__construct($repository);

        $this->getAreasInteractor = $getAreasInteractor;
        $this->getBlocksInteractor = $getBlocksInteractor;
        $this->createPageInteractor = $createPageInteractor;
        $this->createAreaInteractor = $createAreaInteractor;
        $this->createBlockInteractor = $createBlockInteractor;
        $this->updateBlockInteractor = $updateBlockInteractor;
    }

    public function run($pageID)
    {
        if ($page = $this->getPageByID($pageID)) {
            $newPageID = $this->duplicatePage($page);

            $areas = $this->getAreasInteractor->getAll($pageID);

            foreach ($areas as $area) {
                $newAreaID = $this->duplicateArea($area, $newPageID);
                $blocks = $this->getBlocksInteractor->getAll($area->getID());

                foreach ($blocks as $block) {
                    $this->duplicateBlock($block, $newAreaID);
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

    private function duplicateArea($area, $newPageID)
    {
        $areaStructure = AreaStructure::toStructure($area);
        $areaStructure->ID = null;
        $areaStructure->page_id = $newPageID;

        return $this->createAreaInteractor->run($areaStructure);
    }

    private function duplicateBlock($block, $newAreaID)
    {
        $blockStructure = BlockStructure::toStructure($block);
        $blockStructure->ID = null;
        $blockStructure->area_id = $newAreaID;

        $blockID = $this->createBlockInteractor->run($blockStructure);
        $blockStructureContent = new BlockStructure();

        if ($block->getType() == 'html') {
            $blockStructureContent = new HTMLBlockStructure([
                'html' => $block->getHTML(),
            ]);
        } elseif ($block->getType() == 'menu') {
            $blockStructureContent = new MenuBlockStructure([
                'menu_id' => $block->getMenuID(),
            ]);
        } elseif ($block->getType() == 'view_file') {
            $blockStructureContent = new ViewFileBlockStructure([
                'view_file' => $block->getViewFile(),
            ]);
        } elseif ($block->getType() == 'article') {
            $blockStructureContent = new ArticleBlockStructure([
                'article_id' => $block->getArticleID(),
            ]);
        } elseif ($block->getType() == 'article_list') {
            $blockStructureContent = new ArticleListBlockStructure([
                'article_list_category_id' => $block->getArticleListCategoryID(),
                'article_list_order' => $block->getArticleListOrder(),
                'article_list_number' => $block->getArticleListNumber(),
            ]);
        }

        $this->updateBlockInteractor->run($blockID, $blockStructureContent);
    }
}