<?php

use CMS\Context;
use CMS\Entities\Area;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Entities\Lang;
use CMS\Entities\Page;
use CMSTests\PageRenderer;

class FunctionalTest extends PHPUnit_Framework_TestCase
{
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