<?php

namespace CMS\Structures;

use CMS\Entities\Blocks\ArticleBlock;
use CMS\Entities\Blocks\ArticleListBlock;
use CMS\Entities\Blocks\GlobalBlock;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Entities\Blocks\MenuBlock;
use CMS\Entities\Blocks\ViewFileBlock;
use CMS\Structures\Blocks\ArticleBlockStructure;
use CMS\Structures\Blocks\ArticleListBlockStructure;
use CMS\Structures\Blocks\GlobalBlockStructure;
use CMS\Structures\Blocks\HTMLBlockStructure;
use CMS\Structures\Blocks\MenuBlockStructure;
use CMS\Structures\Blocks\ViewFileBlockStructure;

class BlockStructure extends DataStructure
{
    public $ID;
    public $name;
    public $width;
    public $height;
    public $class;
    public $order;
    public $type;
    public $area_id;
    public $display;
    public $is_global;
    public $is_master;
    public $master_block_id;
    public $is_ghost;

    public static function toStructure($block)
    {
        if ($block instanceof HTMLBlock && $block->getType() == 'html') {
            $blockStructure = new HTMLBlockStructure();
            $blockStructure->html = $block->getHTML();
        } elseif ($block instanceof MenuBlock && $block->getType() == 'menu') {
            $blockStructure = new MenuBlockStructure();
            $blockStructure->menu_id = $block->getMenuID();
        } elseif ($block instanceof ViewFileBlock && $block->getType() == 'view_file') {
            $blockStructure = new ViewFileBlockStructure();
            $blockStructure->view_file = $block->getViewFile();
        } elseif ($block instanceof ArticleBlock && $block->getType() == 'article') {
            $blockStructure = new ArticleBlockStructure();
            $blockStructure->article_id = $block->getArticleID();
        } elseif ($block instanceof ArticleListBlock && $block->getType() == 'article_list') {
            $blockStructure = new ArticleListBlockStructure();
            $blockStructure->article_list_category_id = $block->getArticleListCategoryID();
            $blockStructure->article_list_order = $block->getArticleListOrder();
            $blockStructure->article_list_number = $block->getArticleListNumber();
        } elseif ($block instanceof GlobalBlock && $block->getType() == 'global') {
            $blockStructure = new GlobalBlockStructure();
            $blockStructure->block_reference_id = $block->getBlockReferenceID();
        } else {
            $blockStructure = new BlockStructure();
        }

        $blockStructure->ID = $block->getID();
        $blockStructure->name = $block->getName();
        $blockStructure->width = $block->getWidth();
        $blockStructure->height = $block->getHeight();
        $blockStructure->class = $block->getClass();
        $blockStructure->order = $block->getOrder();
        $blockStructure->type = $block->getType();
        $blockStructure->area_id = $block->getAreaID();
        $blockStructure->display = $block->getDisplay();
        $blockStructure->is_global = $block->getIsGlobal();
        $blockStructure->is_master = $block->getIsMaster();
        $blockStructure->master_block_id = $block->getMasterBlockID();
        $blockStructure->is_ghost = $block->getIsGhost();

        return $blockStructure;
    }
}
