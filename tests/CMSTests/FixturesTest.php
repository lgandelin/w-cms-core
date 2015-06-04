<?php

use CMS\Context;
use CMS\Entities\Area;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Entities\Blocks\MenuBlock;
use CMS\Entities\Lang;
use CMS\Entities\Menu;
use CMS\Entities\MenuItem;
use CMS\Entities\Page;
use CMS\Interactors\Pages\GetPageContentInteractor;
use CMSTests\PageRenderer;

class FixturesTest extends PHPUnit_Framework_TestCase
{
    public function testGetPageContentInteractor()
    {
        $langID = $this->createLangFixture('Français', 'fr', true);
        $pageID = $this->createPageFixture('Page 1', '/home', $langID);
        $areaID = $this->createAreaFixture('Area 1', 12, true, 1, $pageID);
        $this->createHMTLBlockFixture('Block 1', 6, true, 1, $areaID, 'Hello World !');

        $pageData = (new GetPageContentInteractor())->run('/home');
        $this->assertEquals('<page><title>Page 1</title><area><title>Area 1 (12)</title><block><title>Block 1 (6)</title><content>Hello World !</content></block></area></page>', PageRenderer::render($pageData));
    }

    public function testGetBlocksInteractor()
    {
        $langID = $this->createLangFixture('Français', 'fr', true);
        $menuID = $this->createMenuFixture('Menu 1', 'menu-1', $langID);
        $this->createMenuItemFixture('Menu Item 1', 1, $menuID);
        $this->createMenuItemFixture('Menu Item 2', 2, $menuID);
        $pageID = $this->createPageFixture('Page 1', '/home', $langID);
        $areaID = $this->createAreaFixture('Area 1', 12, true, 1, $pageID);
        $this->createMenuBlockFixture('Block 1', 6, true, 1, $areaID, $menuID);

        $pageData = (new GetPageContentInteractor())->run('/home');
        $this->assertEquals('<page><title>Page 1</title><area><title>Area 1 (12)</title><block><title>Block 1 (6)</title><content><item>Menu Item 1</item><item>Menu Item 2</item></content></block></area></page>', PageRenderer::render($pageData));
    }

    private function createLangFixture($name = '', $code = '', $isDefault = false)
    {
        $lang = new Lang();
        $lang->setName($name);
        $lang->setCode($code);
        $lang->setIsDefault($isDefault);

        return Context::$langRepository->createLang($lang);
    }

    private function createPageFixture($name, $uri, $langID)
    {
        $page = new Page();
        $page->setName($name);
        $page->setUri($uri);
        $page->setLangID($langID);

        return Context::$pageRepository->createPage($page);
    }

    private function createMenuFixture($name, $identifier, $langID)
    {
        $menu = new Menu();
        $menu->setName($name);
        $menu->setIdentifier($identifier);
        $menu->setLangID($langID);

        return Context::$menuRepository->createMenu($menu);
    }

    private function createMenuItemFixture($label, $order, $menuID)
    {
        $menuItem = new MenuItem();
        $menuItem->setLabel($label);
        $menuItem->setOrder($order);
        $menuItem->setMenuID($menuID);

        return Context::$menuItemRepository->createMenuItem($menuItem);
    }

    private function createAreaFixture($name, $width, $display, $order, $pageID)
    {
        $area = new Area();
        $area->setName($name);
        $area->setWidth($width);
        $area->setDisplay($display);
        $area->setOrder($order);
        $area->setPageID($pageID);

        return Context::$areaRepository->createArea($area);
    }

    private function createHMTLBlockFixture($name, $width, $display, $order, $areaID, $html)
    {
        $block = new HTMLBlock();
        $block->setName($name);
        $block->setWidth($width);
        $block->setDisplay($display);
        $block->setOrder($order);
        $block->setHTML($html);
        $block->setAreaID($areaID);
        $block->setType('html');

        return Context::$blockRepository->createBlock($block);
    }

    private function createMenuBlockFixture($name, $width, $display, $order, $areaID, $menuID)
    {
        $block = new MenuBlock();
        $block->setName($name);
        $block->setWidth($width);
        $block->setDisplay($display);
        $block->setOrder($order);
        $block->setMenuID($menuID);
        $block->setAreaID($areaID);
        $block->setType('menu');

        return Context::$blockRepository->createBlock($block);
    }
} 