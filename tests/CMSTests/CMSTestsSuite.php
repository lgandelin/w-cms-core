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
        Context::$pageRepository = new InMemoryPageRepository();
        Context::$areaRepository = new InMemoryAreaRepository();
        Context::$langRepository = new InMemoryLangRepository();
        Context::$blockRepository = new InMemoryBlockRepository();
        Context::$menuRepository = new InMemoryMenuRepository();
        Context::$menuItemRepository = new InMemoryMenuItemRepository();
        Context::$articleRepository = new InMemoryArticleRepository();
        Context::$articleCategoryRepository = new InMemoryArticleCategoryRepository();
        Context::$mediaRepository = new InMemoryMediaRepository();
        Context::$mediaFormatRepository = new InMemoryMediaFormatRepository();
        Context::$userRepository = new InMemoryUserRepository();
    }

    public static function suite()
    {
        $suite = new self();

        return $suite;
    }

    public static function clean()
    {
        foreach (Context::$blockRepository->findAll() as $block)
            Context::$blockRepository->deleteBlock($block->getID());

        foreach (Context::$areaRepository->findAll() as $area)
            Context::$areaRepository->deleteArea($area->getID());

        foreach (Context::$pageRepository->findAll() as $page)
            Context::$pageRepository->deletePage($page->getID());

        foreach (Context::$articleRepository->findAll() as $article)
            Context::$articleRepository->deleteArticle($article->getID());

        foreach (Context::$articleCategoryRepository->findAll() as $articleCategory)
            Context::$articleCategoryRepository->deleteArticleCategory($articleCategory->getID());
    }
}