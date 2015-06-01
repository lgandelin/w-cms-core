<?php

use CMS\Context;
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

class FunctionalTestsSuite extends PHPUnit_Framework_TestSuite
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

    public static function suite()
    {
        $suite = new self();
        $suite->addTestSuite('FunctionalTest');

        return $suite;
    }
}