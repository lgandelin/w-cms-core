<?php

namespace CMS\Interactors\Blocks;

use CMS\Interactors\Articles\GetArticleInteractor;
use CMS\Interactors\Articles\GetArticlesInteractor;
use CMS\Interactors\MediaFormats\GetMediaFormatInteractor;
use CMS\Interactors\Medias\GetMediaInteractor;
use CMS\Interactors\MenuItems\GetMenuItemsInteractor;
use CMS\Interactors\Menus\GetMenuInteractor;
use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Interactors\Users\GetUserInteractor;
use CMS\Structures\Blocks\ArticleBlockStructure;
use CMS\Structures\Blocks\ArticleListBlockStructure;
use CMS\Structures\Blocks\GlobalBlockStructure;
use CMS\Structures\Blocks\MediaBlockStructure;
use CMS\Structures\Blocks\MenuBlockStructure;
use CMS\Structures\BlockStructure;

class GetBlockContentInteractor
{
    public function run(BlockStructure $block, $structure = false)
    {
        if ($block instanceof MenuBlockStructure && $block->menu_id) {
            $block->menu = (new GetMenuInteractor())->getMenuByID($block->menu_id, $structure);
            $menuItems = (new GetMenuItemsInteractor())->getAll($block->menu_id, $structure);

            foreach ($menuItems as $menuItem)
                if ($menuItem->page_id)
                    $menuItem->page = (new GetPageInteractor())->getPageByID($menuItem->page_id, $structure);

            $block->menu->items =$menuItems;
        }

        elseif ($block instanceof ArticleBlockStructure && $block->article_id) {
            $block->article = (new GetArticleInteractor())->getArticleByID($block->article_id, $structure);

            if ($block->article->author_id)
                $block->article->author = (new GetUserInteractor())->getUserByID($block->article->author_id, $structure);

            if ($block->article->page_id)
                $block->article->page = (new GetPageInteractor())->getPageByID($block->article->page_id, $structure);
        }

        elseif ($block instanceof ArticleListBlockStructure) {
            $block->articles = array();
            $block->articles = (new GetArticlesInteractor())->getAll(true, $block->article_list_category_id, $block->article_list_number, $block->article_list_order);
            foreach ($block->articles as $article) {
                if ($article->page_id)
                    $article->page = (new GetPageInteractor())->getPageByID($article->page_id, $structure);

                if ($article->media_id)
                    $article->media = (new GetMediaInteractor())->getMediaByID($article->media_id, $structure);
            }
        }

        else if ($block instanceof GlobalBlockStructure) {

            if ($block->block_reference_id !== null) {
                $oldBlock = $block;
                $block = (new GetBlockInteractor())->getBlockByID($block->block_reference_id, $structure);
                $block = self::run($block);

                $block->ID = $oldBlock->ID;
                $block->display = $oldBlock->display;
                $block->area_id = $oldBlock->area_id;
                $block->name = $oldBlock->name;
                $block->class .= ' ' . $oldBlock->class;
                $block->width  = $oldBlock->width;
                $block->height = $oldBlock->height;
            }
        }

        else if ($block instanceof MediaBlockStructure && $block->media_id) {
            $block->media = (new GetMediaInteractor())->getMediaByID($block->media_id, true);

            if ($block->media_format_id) {
                $mediaFormat = (new GetMediaFormatInteractor())->getMediaFormatByID($block->media_format_id, true);
                $block->media->file_name = $mediaFormat->width . '_' . $mediaFormat->height . '_' . $block->media->file_name;
            }
        }

        return $block;
    }
} 