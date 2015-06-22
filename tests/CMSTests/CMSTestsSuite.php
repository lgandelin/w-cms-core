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
        Context::addRepository('page', new InMemoryPageRepository());
        Context::addRepository('area', new InMemoryAreaRepository());
        Context::addRepository('lang', new InMemoryLangRepository());
        Context::addRepository('block', new InMemoryBlockRepository());
        Context::addRepository('menu', new InMemoryMenuRepository());
        Context::addRepository('menu_item', new InMemoryMenuItemRepository());
        Context::addRepository('article', new InMemoryArticleRepository());
        Context::addRepository('article_category', new InMemoryArticleCategoryRepository());
        Context::addRepository('media', new InMemoryMediaRepository());
        Context::addRepository('media_format', new InMemoryMediaFormatRepository());
        Context::addRepository('user', new InMemoryUserRepository());
    }

    public static function suite()
    {
        $suite = new self();

        return $suite;
    }

    public static function clean()
    {
        foreach (Context::getRepository('block')->findAll() as $block)
            Context::getRepository('block')->deleteBlock($block->getID());

        foreach (Context::getRepository('area')->findAll() as $area)
            Context::getRepository('area')->deleteArea($area->getID());

        foreach (Context::getRepository('page')->findAll() as $page)
            Context::getRepository('page')->deletePage($page->getID());

        foreach (Context::getRepository('article')->findAll() as $article)
            Context::getRepository('article')->deleteArticle($article->getID());

        foreach (Context::getRepository('article_category')->findAll() as $articleCategory)
            Context::getRepository('article_category')->deleteArticleCategory($articleCategory->getID());

        foreach (Context::getRepository('lang')->findAll() as $lang)
            Context::getRepository('lang')->deleteLang($lang->getID());

        foreach (Context::getRepository('user')->findAll() as $user)
            Context::getRepository('user')->deleteUser($user->getID());

        foreach (Context::getRepository('menu_item')->findAll() as $menuItem)
            Context::getRepository('menu_item')->deleteMenuItem($menuItem->getID());

        foreach (Context::getRepository('menu')->findAll() as $menu)
            Context::getRepository('menu')->deleteMenu($menu->getID());

        foreach (Context::getRepository('media')->findAll() as $media)
            Context::getRepository('media')->deleteMedia($media->getID());

        foreach (Context::getRepository('media_format')->findAll() as $mediaFormat)
            Context::getRepository('media_format')->deleteMediaFormat($mediaFormat->getID());
    }
}