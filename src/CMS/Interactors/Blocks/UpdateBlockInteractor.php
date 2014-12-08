<?php

namespace CMS\Interactors\Blocks;

use CMS\Structures\Blocks\ArticleBlockStructure;
use CMS\Structures\Blocks\ArticleListBlockStructure;
use CMS\Structures\BlockStructure;
use CMS\Structures\Blocks\MenuBlockStructure;
use CMS\Structures\Blocks\HTMLBlockStructure;
use CMS\Structures\Blocks\ViewFileBlockStructure;

class UpdateBlockInteractor extends GetBlockInteractor
{
    public function run($blockID, BlockStructure $blockStructure)
    {
        if ($block = $this->getBlockByID($blockID)) {
            if ($blockStructure->type !== null && $blockStructure->type != $block->getType()) {
                $block->setType($blockStructure->type);
            }
            $this->repository->updateBlockType($block);
        }

        if ($block = $this->getBlockByID($blockID)) {
            if ($blockStructure->name !== null && $blockStructure->name != $block->getName()) {
                $block->setName($blockStructure->name);
            }
            if ($blockStructure->width !== null && $blockStructure->width != $block->getWidth()) {
                $block->setWidth($blockStructure->width);
            }
            if ($blockStructure->height !== null && $blockStructure->height != $block->getHeight()) {
                $block->setHeight($blockStructure->height);
            }
            if ($blockStructure->class !== null && $blockStructure->class != $block->getClass()) {
                $block->setClass($blockStructure->class);
            }
            if ($blockStructure->order !== null && $blockStructure->order != $block->getOrder()) {
                $block->setOrder($blockStructure->order);
            }
            if ($blockStructure->area_id !== null && $blockStructure->area_id != $block->getAreaId()) {
                $block->setAreaID($blockStructure->area_id);
            }
            if ($blockStructure->display !== null && $blockStructure->display != $block->getDisplay()) {
                $block->setDisplay($blockStructure->display);
            }

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
        }

        $this->repository->updateBlock($block);
    }
}
