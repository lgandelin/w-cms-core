<?php

namespace CMS\Interactors\Blocks;

use CMS\Repositories\BlockRepositoryInterface;
use CMS\Structures\BlockStructure;

class UpdateBlockInteractor extends GetBlockInteractor
{
    protected $repository;
    private $getBlocksInteractor;

    public function __construct(BlockRepositoryInterface $repository, GetBlocksInteractor $getBlocksInteractor)
    {
        $this->repository = $repository;
        $this->getBlocksInteractor = $getBlocksInteractor;
    }

    public function run($blockID, BlockStructure $blockStructure)
    {
        if ($block = $this->getBlockByID($blockID)) {
            if ($blockStructure->type !== null && $blockStructure->type != $block->getType()) {
                $block->setType($blockStructure->type);
            }
            $this->repository->updateBlockType($block);
        }

        if ($block = $this->getBlockByID($blockID)) {
            $block->setInfos($blockStructure);

            if (!$block->getIsGhost()) {
<<<<<<< HEAD
                $block->updateContent($blockStructure);
=======
                if ($blockStructure instanceof HTMLBlockStructure && $block->getType() == 'html' && $blockStructure->html !== null && $blockStructure->html != $block->getHTML()) {
                    $block->setHTML($blockStructure->html);
                }

                if ($blockStructure instanceof MenuBlockStructure && $block->getType() == 'menu' && $blockStructure->menu_id !== null && $blockStructure->menu_id != $block->getMenuID()) {
                    $block->setMenuID($blockStructure->menu_id);
                }

                if ($blockStructure instanceof ViewFileBlockStructure && $block->getType() == 'view_file' && $blockStructure->view_file !== null && $blockStructure->view_file != $block->getViewFile()) {
                    $block->setViewFile($blockStructure->view_file);
                }

                if ($blockStructure instanceof ArticleBlockStructure && $block->getType() == 'article' && $blockStructure->article_id != $block->getArticleID()) {
                    $block->setArticleID($blockStructure->article_id);
                }

                if ($blockStructure instanceof ArticleListBlockStructure && $block->getType() == 'article_list' && ($blockStructure->article_list_category_id != $block->getArticleListCategoryID() || $blockStructure->article_list_order != $block->getArticleListOrder() || $blockStructure->article_list_number != $block->getArticleListNumber())) {
                    $block->setArticleListCategoryID($blockStructure->article_list_category_id);
                    $block->setArticleListOrder($blockStructure->article_list_order);
                    $block->setArticleListNumber($blockStructure->article_list_number);
                }

                if ($blockStructure instanceof GlobalBlockStructure && $block->getType() == 'global' && $blockStructure->block_reference_id != $block->getBlockReferenceID()) {
                    $block->setBlockReferenceID($blockStructure->block_reference_id);
                }

                if ($blockStructure instanceof MediaBlockStructure && $block->getType() == 'media') {
                    $block->setMediaID($blockStructure->media_id);
                    $block->setMediaLink($blockStructure->media_link);
                }
>>>>>>> Added "media_link" property in MediaBlock
            }

            if ($block->getIsMaster()) {
                unset($blockStructure->area_id);
                unset($blockStructure->is_master);
                $this->updateChildBlocks($blockStructure, $block->getID());
            }
        }

        $this->repository->updateBlock($block);
    }

    private function updateChildBlocks(BlockStructure $blockStructure, $blockID)
    {
        $childBlocks = $this->getBlocksInteractor->getChildBlocks($blockID);

        if (is_array($childBlocks) && sizeof($childBlocks) > 0) {
            foreach ($childBlocks as $child) {
                $this->run($child->getID(), $blockStructure);
            }
        }
    }
}
