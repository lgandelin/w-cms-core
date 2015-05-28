<?php

use CMS\Context;
use CMS\Entities\Area;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Entities\Lang;
use CMS\Entities\Page;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Articles\GetArticleInteractor;
use CMS\Interactors\Articles\GetArticlesInteractor;
use CMS\Interactors\Blocks\GetBlockContentInteractor;
use CMS\Interactors\Blocks\GetBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Langs\GetLangInteractor;
use CMS\Interactors\Langs\GetLangsInteractor;
use CMS\Interactors\MediaFormats\GetMediaFormatInteractor;
use CMS\Interactors\Medias\GetMediaInteractor;
use CMS\Interactors\MenuItems\GetMenuItemsInteractor;
use CMS\Interactors\Menus\GetMenuInteractor;
use CMS\Interactors\Pages\GetPageContentInteractor;
use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Interactors\Users\GetUserInteractor;
use CMSTests\PageRenderer;
use CMSTests\Repositories\InMemoryAreaRepository;
use CMSTests\Repositories\InMemoryArticleRepository;
use CMSTests\Repositories\InMemoryBlockRepository;
use CMSTests\Repositories\InMemoryLangRepository;
use CMSTests\Repositories\InMemoryMediaFormatRepository;
use CMSTests\Repositories\InMemoryMediaRepository;
use CMSTests\Repositories\InMemoryMenuItemRepository;
use CMSTests\Repositories\InMemoryMenuRepository;
use CMSTests\Repositories\InMemoryPageRepository;
use CMSTests\Repositories\InMemoryUserRepository;

class FunctionalTest extends PHPUnit_Framework_TestCase
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
        Context::$mediaRepository = new InMemoryMediaRepository();
        Context::$mediaFormatRepository = new InMemoryMediaFormatRepository();
        Context::$userRepository = new InMemoryUserRepository();

        Context::$getPageContentInteractor = new GetPageContentInteractor(
            new GetLangInteractor(Context::$langRepository, new GetLangsInteractor(Context::$langRepository)),
            new GetPageInteractor(Context::$pageRepository),
            new GetAreasInteractor(Context::$areaRepository),
            new GetBlocksInteractor(Context::$blockRepository),
            new GetBlockContentInteractor(
                new GetMenuInteractor(Context::$menuRepository),
                new GetMenuItemsInteractor(Context::$menuItemRepository),
                new GetPageInteractor(Context::$pageRepository),
                new GetArticleInteractor(Context::$articleRepository),
                new GetArticlesInteractor(Context::$articleRepository),
                new GetUserInteractor(Context::$userRepository),
                new GetMediaInteractor(Context::$mediaRepository),
                new GetMediaFormatInteractor(Context::$mediaFormatRepository),
                new GetBlockInteractor(Context::$blockRepository)
            )
        );
    }

    public function testAddAreaToPage()
    {
        $lang = new Lang();
        $lang->setName('Français');
        $lang->setCode('fr');
        $lang->setIsDefault(true);
        $langID = Context::$langRepository->createLang($lang);

        $page = new Page();
        $page->setName('Page 1');
        $page->setLangID($langID);
        $page->setUri('/home');
        $pageID = Context::$pageRepository->createPage($page);

        $area = new Area();
        $area->setName('Area 1');
        $area->setWidth(12);
        $area->setDisplay(true);
        $area->setOrder(1);
        $area->setPageID($pageID);
        $areaID = Context::$areaRepository->createArea($area);

        $block = new HTMLBlock();
        $block->setName('Block 1');
        $block->setWidth(6);
        $block->setDisplay(true);
        $block->setOrder(1);
        $block->setHTML('Hello World !');
        $block->setAreaID($areaID);
        $blockID = Context::$blockRepository->createBlock($block);

        $pageData = Context::$getPageContentInteractor->run($page->getUri());

        $this->assertEquals('<page><title>Page 1</title><area><title>Area 1 (12)</title><block><title>Block 1 (6)</title><content>Hello World !</content></block></area></page>', PageRenderer::render($pageData));

        $block = Context::$blockRepository->findByID($blockID);
        $block->setDisplay(false);

        $this->assertEquals('<page><title>Page 1</title><area><title>Area 1 (12)</title></area></page>', PageRenderer::render($pageData));
    }
} 