<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCoreTests\Repositories\InMemoryAreaRepository;
use Webaccess\WCMSCoreTests\Repositories\InMemoryArticleCategoryRepository;
use Webaccess\WCMSCoreTests\Repositories\InMemoryArticleRepository;
use Webaccess\WCMSCoreTests\Repositories\InMemoryBlockRepository;
use Webaccess\WCMSCoreTests\Repositories\InMemoryLangRepository;
use Webaccess\WCMSCoreTests\Repositories\InMemoryMediaFolderRepository;
use Webaccess\WCMSCoreTests\Repositories\InMemoryMediaFormatRepository;
use Webaccess\WCMSCoreTests\Repositories\InMemoryMediaRepository;
use Webaccess\WCMSCoreTests\Repositories\InMemoryMenuItemRepository;
use Webaccess\WCMSCoreTests\Repositories\InMemoryMenuRepository;
use Webaccess\WCMSCoreTests\Repositories\InMemoryPageRepository;
use Webaccess\WCMSCoreTests\Repositories\InMemoryUserRepository;
use Webaccess\WCMSCoreTests\Repositories\InMemoryVersionRepository;

class CMSTestsSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        Context::add('page_repository', new InMemoryPageRepository());
        Context::add('area_repository', new InMemoryAreaRepository());
        Context::add('lang_repository', new InMemoryLangRepository());
        Context::add('block_repository', new InMemoryBlockRepository());
        Context::add('menu_repository', new InMemoryMenuRepository());
        Context::add('menu_item_repository', new InMemoryMenuItemRepository());
        Context::add('article_repository', new InMemoryArticleRepository());
        Context::add('article_category_repository', new InMemoryArticleCategoryRepository());
        Context::add('media_repository', new InMemoryMediaRepository());
        Context::add('media_format_repository', new InMemoryMediaFormatRepository());
        Context::add('media_folder_repository', new InMemoryMediaFolderRepository());
        Context::add('user_repository', new InMemoryUserRepository());
        Context::add('version_repository', new InMemoryVersionRepository());
    }

    public static function suite()
    {
        $suite = new self();

        return $suite;
    }

    public static function clean()
    {
        foreach (Context::get('block_repository')->findAll() as $block)
            Context::get('block_repository')->deleteBlock($block->getID());

        foreach (Context::get('area_repository')->findAll() as $area)
            Context::get('area_repository')->deleteArea($area->getID());

        foreach (Context::get('page_repository')->findAll() as $page)
            Context::get('page_repository')->deletePage($page->getID());

        foreach (Context::get('article_repository')->findAll() as $article)
            Context::get('article_repository')->deleteArticle($article->getID());

        foreach (Context::get('article_category_repository')->findAll() as $articleCategory)
            Context::get('article_category_repository')->deleteArticleCategory($articleCategory->getID());

        foreach (Context::get('lang_repository')->findAll() as $lang)
            Context::get('lang_repository')->deleteLang($lang->getID());

        foreach (Context::get('user_repository')->findAll() as $user)
            Context::get('user_repository')->deleteUser($user->getID());

        foreach (Context::get('menu_item_repository')->findAll() as $menuItem)
            Context::get('menu_item_repository')->deleteMenuItem($menuItem->getID());

        foreach (Context::get('menu_repository')->findAll() as $menu)
            Context::get('menu_repository')->deleteMenu($menu->getID());

        foreach (Context::get('media_repository')->findAll() as $media)
            Context::get('media_repository')->deleteMedia($media->getID());

        foreach (Context::get('media_format_repository')->findAll() as $mediaFormat)
            Context::get('media_format_repository')->deleteMediaFormat($mediaFormat->getID());

        foreach (Context::get('media_format_repository')->findAll() as $mediaFolder)
            Context::get('media_folder_repository')->deleteMediaFolder($mediaFolder->getID());

        foreach (Context::get('version_repository')->findAll() as $version)
            Context::get('version_repository')->deleteVersion($version->getID());
    }
}