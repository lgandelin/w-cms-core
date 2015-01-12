<?php

namespace CMS\Interactors\Blocks;

use CMS\Structures\Blocks\ArticleBlockStructure;
use CMS\Structures\Blocks\ArticleListBlockStructure;
use CMS\Structures\Blocks\GlobalBlockStructure;
use CMS\Structures\Blocks\HTMLBlockStructure;
use CMS\Structures\Blocks\MenuBlockStructure;
use CMS\Structures\Blocks\ViewFileBlockStructure;
use CMS\Structures\BlockStructure;

class DuplicateBlockInteractor
{
    private $createBlockInteractor;
    private $updateBlockInteractor;

    public function __construct(CreateBlockInteractor $createBlockInteractor, UpdateBlockInteractor $updateBlockInteractor)
    {
        $this->createBlockInteractor = $createBlockInteractor;
        $this->updateBlockInteractor = $updateBlockInteractor;
    }

    public function run($block, $newAreaID)
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
        } elseif ($block->getType() == 'global') {
            $blockStructureContent = new GlobalBlockStructure([
                'block_reference_id' => $block->getBlockReferenceID()
            ]);
        }

        $this->updateBlockInteractor->run($blockID, $blockStructureContent);

        return $blockID;
    }
} 