<?php

use CMS\Context;
use CMSTests\Repositories\InMemoryAreaRepository;
use CMSTests\Repositories\InMemoryArticleCategoryRepository;
use CMSTests\Repositories\InMemoryArticleRepository;
use CMSTests\Repositories\InMemoryBlockRepository;
use CMSTests\Repositories\InMemoryLangRepository;
use CMSTests\Repositories\InMemoryMediaFormatRepository;
use CMSTests\Repositories\InMemoryMediaRepository;
use CMSTests\Repositories\InMemoryMenuItemRepository;
use CMSTests\Repositories\InMemoryMenuRepository;
use CMSTests\Repositories\InMemoryPageRepository;
use CMSTests\Repositories\InMemoryUserRepository;

class CMSTestsSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        Context::add('page', new InMemoryPageRepository());
        Context::add('area', new InMemoryAreaRepository());
        Context::add('lang', new InMemoryLangRepository());
        Context::add('block', new InMemoryBlockRepository());
        Context::add('menu', new InMemoryMenuRepository());
        Context::add('menu_item', new InMemoryMenuItemRepository());
        Context::add('article', new InMemoryArticleRepository());
        Context::add('article_category', new InMemoryArticleCategoryRepository());
        Context::add('media', new InMemoryMediaRepository());
        Context::add('media_format', new InMemoryMediaFormatRepository());
        Context::add('user', new InMemoryUserRepository());
    }

    public static function suite()
    {
        $suite = new self();

        return $suite;
    }

    public static function clean()
    {
        foreach (Context::get('block')->findAll() as $block)
            Context::get('block')->deleteBlock($block->getID());

        foreach (Context::get('area')->findAll() as $area)
            Context::get('area')->deleteArea($area->getID());

        foreach (Context::get('page')->findAll() as $page)
            Context::get('page')->deletePage($page->getID());

        foreach (Context::get('article')->findAll() as $article)
            Context::get('article')->deleteArticle($article->getID());

        foreach (Context::get('article_category')->findAll() as $articleCategory)
            Context::get('article_category')->deleteArticleCategory($articleCategory->getID());

        foreach (Context::get('lang')->findAll() as $lang)
            Context::get('lang')->deleteLang($lang->getID());

        foreach (Context::get('user')->findAll() as $user)
            Context::get('user')->deleteUser($user->getID());

        foreach (Context::get('menu_item')->findAll() as $menuItem)
            Context::get('menu_item')->deleteMenuItem($menuItem->getID());

        foreach (Context::get('menu')->findAll() as $menu)
            Context::get('menu')->deleteMenu($menu->getID());

        foreach (Context::get('media')->findAll() as $media)
            Context::get('media')->deleteMedia($media->getID());

        foreach (Context::get('media_format')->findAll() as $mediaFormat)
            Context::get('media_format')->deleteMediaFormat($mediaFormat->getID());
    }
}